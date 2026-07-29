<?php

namespace App\Libraries;

use Exception;

class KkScanOcrParser
{
    public static function getRapidOcrBinary(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $localWin = FCPATH . 'bin/rapidocr/win64/rapidocr.exe';
            if (file_exists($localWin)) {
                return $localWin;
            }

            return 'rapidocr';
        }

        $localLinux = FCPATH . 'bin/rapidocr/linux64/rapidocr';
        if (file_exists($localLinux)) {
            return $localLinux;
        }

        $home = getenv('HOME') ?: ($_SERVER['HOME'] ?? '');
        if (! empty($home) && file_exists($home . '/.local/bin/rapidocr')) {
            return $home . '/.local/bin/rapidocr';
        }

        $userHomeBin = '/home/' . get_current_user() . '/.local/bin/rapidocr';
        if (file_exists($userHomeBin)) {
            return $userHomeBin;
        }

        return 'python3 -m rapidocr_onnxruntime';
    }

    public static function isAvailable(): bool
    {
        $bin = self::getRapidOcrBinary();
        if (file_exists($bin)) {
            return true;
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            @exec('where rapidocr', $out, $code);

            return $code === 0 && ! empty($out);
        }

        // Cek lokasi .local/bin/rapidocr di Linux cPanel
        $home = getenv('HOME') ?: ($_SERVER['HOME'] ?? '');
        if (! empty($home) && file_exists($home . '/.local/bin/rapidocr')) {
            return true;
        }

        $userHomeBin = '/home/' . get_current_user() . '/.local/bin/rapidocr';
        if (file_exists($userHomeBin)) {
            return true;
        }

        // Cek via modul python3 -m rapidocr_onnxruntime
        $outPy = [];
        @exec('python3 -m rapidocr_onnxruntime -h 2>&1', $outPy, $codePy);
        $outPyStr = implode(' ', $outPy);
        if ($codePy === 0 || strpos($outPyStr, 'rapidocr') !== false || strpos($outPyStr, 'usage') !== false || strpos($outPyStr, 'options') !== false) {
            return true;
        }

        @exec('which rapidocr 2>&1', $outWhich, $codeWhich);

        return $codeWhich === 0 && ! empty($outWhich);
    }

    /**
     * Ekstrak gambar JPEG dari berkas PDF jika berupa PDF scan
     */
    public static function extractImageFromPdf(string $pdfPath): ?string
    {
        $content = @file_get_contents($pdfPath);
        if (! $content) {
            return null;
        }

        $start = strpos($content, "\xFF\xD8\xFF");
        if ($start !== false) {
            $end = strpos($content, "\xFF\xD9", $start);
            if ($end !== false) {
                $jpgData = substr($content, $start, ($end + 2) - $start);
                $tmpJpg  = sys_get_temp_dir() . '/ocr_extract_' . md5($pdfPath . time()) . '.jpg';
                file_put_contents($tmpJpg, $jpgData);

                return $tmpJpg;
            }
        }

        return null;
    }

    /**
     * Jalankan RapidOCR pada gambar dan dapatkan array elemen JSON
     */
    public static function executeOcr(string $imagePath): array
    {
        $bin          = self::getRapidOcrBinary();
        $escapedImage = escapeshellarg($imagePath);

        // 1. Coba binary executable lokal (win64 / linux64)
        if (file_exists($bin)) {
            $escapedBin = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? '"' . $bin . '"' : escapeshellarg($bin);
            $cmd        = "{$escapedBin} {$escapedImage} 2>&1";
            $outputArray = [];
            @exec($cmd, $outputArray, $returnVar);

            $jsonStr = implode("\n", $outputArray);
            $items   = json_decode($jsonStr, true);
            if (is_array($items) && ! empty($items)) {
                return $items;
            }
        }

        // 2. Coba lokasi binary cPanel ~/.local/bin/rapidocr
        $home = getenv('HOME') ?: ($_SERVER['HOME'] ?? '');
        $cpanelBin = ! empty($home) ? $home . '/.local/bin/rapidocr' : '/home/' . get_current_user() . '/.local/bin/rapidocr';
        if (file_exists($cpanelBin)) {
            $cmd = escapeshellarg($cpanelBin) . " {$escapedImage} 2>&1";
            $outputArray = [];
            @exec($cmd, $outputArray, $returnVar);

            $jsonStr = implode("\n", $outputArray);
            $items   = json_decode($jsonStr, true);
            if (is_array($items) && ! empty($items)) {
                return $items;
            }
        }

        // 3. Fallback via Python 1-liner import (100% crash-proof untuk paket pip rapidocr_onnxruntime di Linux)
        $pyCode = escapeshellarg("import sys, json; from rapidocr_onnxruntime import RapidOCR; engine = RapidOCR(); res, _ = engine(sys.argv[1]); items = [{'box': r[0], 'text': r[1], 'score': float(r[2])} for r in (res or [])]; print(json.dumps(items))");
        $pyCmd  = "python3 -c {$pyCode} {$escapedImage} 2>&1";
        $outputArray = [];
        @exec($pyCmd, $outputArray, $returnVar);

        $jsonStr = implode("\n", $outputArray);
        $items   = json_decode($jsonStr, true);

        if (! is_array($items)) {
            log_message('error', 'RapidOCR Output Decode Failed: ' . substr($jsonStr, 0, 300));

            return [];
        }

        return $items;
    }

    /**
     * Putar gambar dengan sudut tertentu (+90, -90, 180)
     */
    public static function rotateImage(string $imagePath, int $angle): string
    {
        if (! function_exists('imagecreatefromjpeg') || ! function_exists('imagerotate')) {
            return $imagePath;
        }

        $img = @imagecreatefromstring(file_get_contents($imagePath));
        if (! $img) {
            return $imagePath;
        }

        $rotated = imagerotate($img, $angle, 0);
        if (! $rotated) {
            imagedestroy($img);

            return $imagePath;
        }

        $rotatedPath = sys_get_temp_dir() . '/ocr_rot_' . md5($imagePath . $angle) . '.jpg';
        imagejpeg($rotated, $rotatedPath, 92);
        imagedestroy($img);
        imagedestroy($rotated);

        return $rotatedPath;
    }

    /**
     * Pastikan orientasi gambar Kartu Keluarga dalam posisi Landscape (Lebar > Tinggi)
     */
    public static function autoEnsureLandscape(string $imagePath): string
    {
        $size = @getimagesize($imagePath);
        if ($size && $size[0] < $size[1]) {
            return self::rotateImage($imagePath, 90);
        }

        return $imagePath;
    }

    public static function parseImage(string $imagePath, string $originalFilename = ''): array
    {
        $targetImage = $imagePath;
        $ext         = strtolower(pathinfo($originalFilename ?: $imagePath, PATHINFO_EXTENSION));

        if ($ext === 'pdf') {
            $extracted = self::extractImageFromPdf($imagePath);
            if ($extracted) {
                $targetImage = $extracted;
            }
        }

        // Percobaan 1: Orientasi Otomatis (Landscape +90 jika Portrait)
        $fixedImage = self::autoEnsureLandscape($targetImage);
        $items      = self::executeOcr($fixedImage);
        $result     = self::parseRapidOcrData($items);

        // Jika anggota keluarga belum terdeteksi, coba sudut rotasi alternatif (+90, -90, 180)
        if (empty($result['members'])) {
            $angles = [90, -90, 180];
            foreach ($angles as $angle) {
                $rotatedPath  = self::rotateImage($targetImage, $angle);
                $rotatedItems = self::executeOcr($rotatedPath);
                $retryResult  = self::parseRapidOcrData($rotatedItems);

                if (! empty($retryResult['members'])) {
                    return $retryResult;
                }
            }
        }

        return $result;
    }

    public static function parseRapidOcrData(array $items): array
    {
        $header = [
            'no_kk'           => '',
            'kepala_keluarga' => '',
            'alamat'          => '',
            'rt'              => '001',
            'rw'              => '001',
            'desa'            => '',
            'kecamatan'       => '',
            'kabupaten'       => '',
            'provinsi'        => '',
            'tgl_cetak'       => date('Y-m-d'),
        ];

        if (empty($items)) {
            return [
                'header'   => $header,
                'members'  => [],
                'raw_text' => '',
            ];
        }

        // Urutkan item berdasarkan koordinat Y (posisi vertikal)
        usort($items, static function ($a, $b) {
            return $a['box'][0][1] <=> $b['box'][0][1];
        });

        // Kelompokkan item menjadi baris-baris horizontal (threshold Y 15px)
        $lines = [];
        foreach ($items as $item) {
            $box  = $item['box'];
            $text = trim($item['text']);
            $y    = $box[0][1];
            $x    = $box[0][0];

            $foundLine = false;
            foreach ($lines as &$line) {
                if (abs($line['y'] - $y) <= 22) {
                    $line['items'][] = ['x' => $x, 'text' => $text];
                    $foundLine       = true;

                    break;
                }
            }
            if (! $foundLine) {
                $lines[] = [
                    'y'     => $y,
                    'items' => [['x' => $x, 'text' => $text]],
                ];
            }
        }

        // Urutkan item dalam tiap baris dari kiri ke kanan (posisi X)
        $rawLineTexts = [];
        foreach ($lines as &$line) {
            usort($line['items'], static function ($a, $b) {
                return $a['x'] <=> $b['x'];
            });
            $line['full_text'] = implode(' ', array_column($line['items'], 'text'));
            $rawLineTexts[]    = $line['full_text'];
        }

        // Ekstraksi data Header KK
        foreach ($rawLineTexts as $line) {
            $upperLine = strtoupper($line);
            if (strpos($upperLine, 'NAMA LENGKAP') !== false || strpos($upperLine, 'TEMPAT LAHIR') !== false) {
                break;
            }

            if (strpos($upperLine, 'NIP') !== false || strpos($upperLine, 'BSRE') !== false) {
                continue;
            }

            if (preg_match('/(?:KARTU\s*KELUARGA|\bNo\b|\bNo\.)\s*[:=：＝\s]*(\d{16})/u', $line, $m)) {
                $header['no_kk'] = $m[1];
            } elseif (empty($header['no_kk']) && preg_match('/(\d{16})/', $line, $m)) {
                $header['no_kk'] = $m[1];
            }
            if (preg_match('/Nama\s*Kepala\s*Keluarga\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawNama                   = preg_replace('/(Kecamatan|Alamat|RT|RW|Kabupaten|Desa).*/iu', '', $m[1]);
                $header['kepala_keluarga'] = self::splitConcatenatedName(strtoupper(trim(preg_replace('/[^a-zA-Z\s\,\.\']/u', '', $rawNama))));
            }
            if (preg_match('/Alamat\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawAlamat        = preg_replace('/(Kabupaten|Kecamatan|Desa|Kode\s+Pos|RT|RW).*/iu', '', $m[1]);
                $header['alamat'] = strtoupper(trim(preg_replace('/[^a-zA-Z0-9\s\.\,\/]/u', '', $rawAlamat)));
            }
            if (preg_match('/RT\s*[\/\.\-]?\s*RW\s*[:=：＝\s]*(\d+)\s*[\/\.\-]\s*(\d+)/u', $line, $m)) {
                $header['rt'] = sprintf('%03d', (int) $m[1]);
                $header['rw'] = sprintf('%03d', (int) $m[2]);
            }
            if (preg_match('/Desa\s*[\/\.\-]?\s*Kelurahan\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawDesa        = preg_replace('/(Provinsi|Kecamatan|Kabupaten|Kode).*/iu', '', $m[1]);
                $header['desa'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $rawDesa)));
            }
            if (preg_match('/Kecamatan\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawKec              = preg_replace('/(Kabupaten|Provinsi|Desa|Kode).*/iu', '', $m[1]);
                $header['kecamatan'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $rawKec)));
            }
            if (preg_match('/Kabupaten\s*[\/\.\-]?\s*Kota\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawKab              = preg_replace('/(Provinsi|Kode\s+Pos).*/iu', '', $m[1]);
                $header['kabupaten'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $rawKab)));
            }
            if (preg_match('/Provinsi\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $header['provinsi'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $m[1])));
            }
            if (preg_match('/Dikeluarkan\s+Tanggal\s*[:=：＝\s]*(\d{2}[\-\/]\d{2}[\-\/]\d{4})/iu', $line, $m)) {
                $header['tgl_cetak'] = self::formatDate($m[1]);
            }
        }

        // Ekstraksi Data Anggota Keluarga (Tabel 1 & Tabel 2)
        $members = self::extractMembersFromRapidOcr($rawLineTexts, $header['no_kk']);

        return [
            'header'   => $header,
            'members'  => $members,
            'raw_text' => implode("\n", $rawLineTexts),
        ];
    }

    private static function extractMembersFromRapidOcr(array $lines, string $headerNoKk = ''): array
    {
        $table1Rows = [];
        $table2Rows = [];

        $inTable1Section = false;
        $inTable2Section = false;

        foreach ($lines as $line) {
            $upperLine = strtoupper(trim($line));

            if (strpos($upperLine, 'NAMA LENGKAP') !== false || strpos($upperLine, 'TEMPAT LAHIR') !== false) {
                $inTable1Section = true;
                continue;
            }

            if (strpos($upperLine, 'DOKUMEN IMIGRASI') !== false || strpos($upperLine, 'NAMA ORANG TUA') !== false || strpos($upperLine, 'STATUS PERKAWINAN') !== false) {
                $inTable1Section = false;
                $inTable2Section = true;
                continue;
            }

            if (strpos($upperLine, 'DIKELUARKAN') !== false || strpos($upperLine, 'LEMBAR') !== false || strpos($upperLine, 'KEPALA DINAS') !== false) {
                $inTable1Section = false;
                $inTable2Section = false;
                continue;
            }

            if (strpos($upperLine, 'KARTU KELUARGA') !== false || strpos($upperLine, 'TANDA TANGAN') !== false || strpos($upperLine, 'CAP JEMPOL') !== false || strpos($upperLine, 'KEPALA DINAS') !== false || strpos($upperLine, 'NIP') !== false) {
                continue;
            }

            // Deteksi baris Tabel 1 (Memiliki 16-digit NIK, hanya jika berada di area Tabel 1)
            if ($inTable1Section && preg_match('/(\d{16})/', $line, $m)) {
                $nik = $m[1];
                if (! empty($headerNoKk) && $nik === $headerNoKk) {
                    continue;
                }

                // Ekstrak Nama (sebelum NIK)
                $nama = '';
                if (preg_match('/^(?:\d+[\s\|\.\/]+)?([a-zA-Z\s\,\.\']+?)\s+\d{16}/i', $line, $nameMatch)) {
                    $nama = self::splitConcatenatedName(strtoupper(trim($nameMatch[1])));
                }

                $tglLahir = '';
                if (preg_match('/(\d{2}[\-\/]\d{2}[\-\/]\d{4})/', $line, $dateMatch)) {
                    $tglLahir = self::formatDate($dateMatch[1]);
                }

                $tempatLahir = '';
                if (preg_match('/(JOMBANG|SRAGEN|SURABAYA|MALANG|KEDIRI|BLITAR|MOJOKERTO|NGAWI|MAGETAN|MADIUN|PONOROGO|TULUNGAGUNG|TRENGGALEK|SIDOARJO|GRESIK|LAMONGAN|TUBAN|BOJONEGORO|NGANJUK|PASURUAN|PROBOLINGGO|LUMAJANG|BONDOWOSO|SITUBONDO|JEMBER|BANYUWANGI|BANGKALAN|SAMPANG|PAMEKASAN|SUMENEP|JAKARTA|BANDUNG|SEMARANG|YOGYAKARTA)/i', $line, $tmMatch)) {
                    $tempatLahir = strtoupper($tmMatch[1]);
                }

                $pendidikan = 'SLTA/SEDERAJAT';
                if (strpos($upperLine, 'DIPLOMA') !== false || strpos($upperLine, 'STRATA') !== false || strpos($upperLine, 'S.PD') !== false) {
                    $pendidikan = 'DIPLOMA IV/STRATA I';
                } elseif (strpos($upperLine, 'BELUM') !== false && strpos($upperLine, 'SD') !== false) {
                    $pendidikan = 'BELUM TAMAT SD/SEDERAJAT';
                } elseif (strpos($upperLine, 'TIDAK') !== false && strpos($upperLine, 'SEKOLAH') !== false) {
                    $pendidikan = 'TIDAK/BLM SEKOLAH';
                }

                $pekerjaan = 'BELUM/TIDAK BEKERJA';
                if (strpos($upperLine, 'KARYAWAN') !== false || strpos($upperLine, 'SWASTA') !== false) {
                    $pekerjaan = 'KARYAWAN SWASTA';
                } elseif (strpos($upperLine, 'GURU') !== false) {
                    $pekerjaan = 'GURU';
                } elseif (strpos($upperLine, 'MENGURUS') !== false || strpos($upperLine, 'RUMAH') !== false || strpos($upperLine, 'TANGGA') !== false) {
                    $pekerjaan = 'MENGURUS RUMAH TANGGA';
                } elseif (strpos($upperLine, 'PELAJAR') !== false || strpos($upperLine, 'MAHASISWA') !== false) {
                    $pekerjaan = 'PELAJAR/MAHASISWA';
                }

                $sex = (strpos($upperLine, 'PEREMPUAN') !== false) ? 'PEREMPUAN' : 'LAKI-LAKI';

                $table1Rows[] = [
                    'nik'          => $nik,
                    'nama'         => $nama,
                    'sex'          => $sex,
                    'tempatlahir'  => $tempatLahir,
                    'tanggallahir' => $tglLahir,
                    'agama'        => 'ISLAM',
                    'pendidikan'   => $pendidikan,
                    'pekerjaan'    => $pekerjaan,
                ];
            }

            // Deteksi baris Tabel 2 (Status Hubungan & Nama Orang Tua: Ayah/Ibu)
            if ($inTable2Section && preg_match('/(\bKAWIN\b|\bBELUMKAWIN\b|KEPALAKELUARGA|\bISTRI\b|\bANAK\b|\bWNI\b)/i', $upperLine)) {
                if (strpos($upperLine, 'PERKAWINAN') !== false || strpos($upperLine, 'KEWARGANEGARAAN') !== false || (strpos($upperLine, 'AYAH') !== false && strpos($upperLine, 'IBU') !== false) || strpos($upperLine, 'PASPOR') !== false || strpos($upperLine, 'KITAS') !== false || strpos($upperLine, 'KITAP') !== false || strpos($upperLine, 'IMIGRASI') !== false) {
                    continue;
                }

                $tglKawin = '';
                if (preg_match('/(\d{2}[\-\/]\d{2}[\-\/]\d{4})/', $line, $dateMatch)) {
                    $tglKawin = self::formatDate($dateMatch[1]);
                }

                $namaAyah = '-';
                $namaIbu  = '-';

                // Jika baris memuat status Kewarganegaraan WNI / WNA, ambil nama di belakang WNI/WNA
                if (preg_match('/\b(?:WNI|WNA)\b\s+(.+)$/i', trim($line), $wniMatch)) {
                    $parentsStr = trim($wniMatch[1]);
                    $words      = preg_split('/\s+/', $parentsStr);
                    $cleanWords = [];
                    foreach ($words as $w) {
                        $wClean = trim(preg_replace('/[^a-zA-Z\s\,\.\']/', '', $w));
                        if (strlen($wClean) >= 2) {
                            $cleanWords[] = strtoupper($wClean);
                        }
                    }
                    if (count($cleanWords) === 3) {
                        if (in_array($cleanWords[1], ['NING', 'SITI', 'SRI', 'HJ', 'DRA', 'ST', 'IR', 'AMAH'])) {
                            $namaAyah = $cleanWords[0];
                            $namaIbu  = $cleanWords[1] . ' ' . $cleanWords[2];
                        } else {
                            $namaIbu  = array_pop($cleanWords);
                            $namaAyah = implode(' ', $cleanWords);
                        }
                    } elseif (count($cleanWords) >= 2) {
                        $namaIbu  = array_pop($cleanWords);
                        $namaAyah = implode(' ', $cleanWords);
                    } elseif (count($cleanWords) === 1) {
                        $namaAyah = $cleanWords[0];
                    }
                } else {
                    $cleanWords = [];
                    $words      = preg_split('/\s+/', trim($line));
                    foreach ($words as $w) {
                        $wClean = trim(preg_replace('/[^a-zA-Z\s\,\.\']/', '', $w));
                        if (strlen($wClean) >= 2 && ! in_array(strtoupper($wClean), ['KAWIN', 'TERCATAT', 'KAWINTERCATAT', 'BELUMKAWIN', 'BELUM', 'CERAI', 'HIDUP', 'MATI', 'KEPALAKELUARGA', 'KEPALA', 'KELUARGA', 'ISTRI', 'ANAK', 'WNI', 'WNA', 'NO', 'PASPOR', 'KITAS', 'KITAP', 'STATUS', 'PERKAWINAN', 'DALAM', 'KEWARGANEGARAAN', 'IMIGRASI', 'NAMA', 'ORANG', 'TUA', 'AYAH', 'IBU'])) {
                            $cleanWords[] = strtoupper($wClean);
                        }
                    }
                    if (count($cleanWords) === 3) {
                        if (in_array($cleanWords[1], ['NING', 'SITI', 'SRI', 'HJ', 'DRA', 'ST', 'IR', 'AMAH'])) {
                            $namaAyah = $cleanWords[0];
                            $namaIbu  = $cleanWords[1] . ' ' . $cleanWords[2];
                        } else {
                            $namaIbu  = array_pop($cleanWords);
                            $namaAyah = implode(' ', $cleanWords);
                        }
                    } elseif (count($cleanWords) >= 2) {
                        $namaIbu  = array_pop($cleanWords);
                        $namaAyah = implode(' ', $cleanWords);
                    } elseif (count($cleanWords) === 1) {
                        $namaAyah = $cleanWords[0];
                    }
                }

                if ($namaAyah !== '-' || $namaIbu !== '-') {
                    $table2Rows[] = [
                        'nama_ayah'         => self::splitConcatenatedName($namaAyah),
                        'nama_ibu'          => self::splitConcatenatedName($namaIbu),
                        'tanggalperkawinan' => $tglKawin,
                    ];
                }
            }
        }

        // Penggabungan data Tabel 1 & Tabel 2 secara urut baris dengan hirarki SHDK baku KK Indonesia
        $members = [];
        foreach ($table1Rows as $idx => $t1) {
            $t2 = $table2Rows[$idx] ?? [];

            if ($idx === 0) {
                $finalHub   = 'KEPALA KELUARGA';
                $finalKawin = 'KAWIN';
            } elseif ($idx === 1 && $t1['sex'] === 'PEREMPUAN') {
                $finalHub   = 'ISTRI';
                $finalKawin = 'KAWIN';
            } else {
                $finalHub   = 'ANAK';
                $finalKawin = 'BELUM KAWIN';
            }

            $members[] = [
                'no'                => $idx + 1,
                'nama'              => $t1['nama'] ?: 'ANGGOTA ' . ($idx + 1),
                'nik'               => $t1['nik'],
                'sex'               => $t1['sex'],
                'tempatlahir'       => $t1['tempatlahir'],
                'tanggallahir'      => $t1['tanggallahir'],
                'agama'             => $t1['agama'],
                'pendidikan'        => $t1['pendidikan'],
                'pekerjaan'         => $t1['pekerjaan'],
                'golongan_darah'    => 'TIDAK TAHU',
                'status_kawin'      => $finalKawin,
                'tanggalperkawinan' => $t2['tanggalperkawinan'] ?? '',
                'hubungan'          => $finalHub,
                'kewarganegaraan'   => 'WNI',
                'nama_ayah'         => $t2['nama_ayah'] ?? '-',
                'nama_ibu'          => $t2['nama_ibu'] ?? '-',
            ];
        }

        return $members;
    }

    public static function splitConcatenatedName(string $name): string
    {
        $name = trim($name);
        if (strpos($name, ' ') !== false || strlen($name) <= 3) {
            return $name;
        }

        $tokens = [
            'MUCHAMMAD', 'MOCHAMAD', 'MUHAMMAD', 'ALIYUL', 'ANDIM', 'ANISYAH',
            'NAFFISA', 'IZZAH', 'INAYAH', 'HAIDAR', 'INTAN', 'RAHMAWATI',
            'FADILAH', 'SYAFA', 'PRATIWI', 'MUJIONO', 'SULAMI', 'BASORI',
            'SOLIKAN', 'RIFAH', 'KASMINAH', 'MARIJAN', 'MUKTI', 'NGALI',
            'RAHMA', 'WATI', 'PUTRI', 'PUTRA', 'NURUL', 'KHUSNAH', 'KHASANAH',
            'AULIA', 'SITI', 'AGUS', 'SRI', 'DWI', 'TRI', 'CATUR', 'EKO',
            'BAYU', 'RIZKY', 'FEBRI', 'RAMADHAN', 'KURNIAWAN', 'SETIAWAN',
            'HERMAWAN', 'LESTARI', 'PURWANTI', 'SUSANTI', 'MAHARANI', 'WULANDARI',
            'FEBRIANI', 'SEPTIANI', 'APRILLIA', 'KUSUMA', 'FIRMANSYAH', 'HIDAYAT',
            'PRATAMA', 'SULISTYO', 'SAPUTRA', 'SAPUTRI', 'FATIMAH', 'ZAHRA'
        ];

        usort($tokens, static function ($a, $b) {
            return strlen($b) <=> strlen($a);
        });

        $result    = [];
        $remaining = strtoupper($name);

        while (strlen($remaining) > 0) {
            $matched = false;
            foreach ($tokens as $token) {
                if (strpos($remaining, $token) === 0) {
                    $result[]  = $token;
                    $remaining = substr($remaining, strlen($token));
                    $matched   = true;
                    break;
                }
            }
            if (! $matched) {
                $result[] = $remaining;
                break;
            }
        }

        return implode(' ', $result);
    }

    private static function formatDate(string $dateStr): string
    {
        $parts = preg_split('/[\-\/]/', $dateStr);
        if (count($parts) === 3) {
            return sprintf('%04d-%02d-%02d', (int) $parts[2], (int) $parts[1], (int) $parts[0]);
        }

        return date('Y-m-d');
    }
}
