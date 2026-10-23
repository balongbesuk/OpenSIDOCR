<?php

namespace App\Libraries;

class KkPdfParser
{
    public static function parseFile($filePath)
    {
        $rawText = self::extractRawText($filePath);
        if (empty($rawText)) {
            $ocrResult = KkScanOcrParser::parseImage($filePath, basename($filePath));
            if (! empty($ocrResult['header']['no_kk']) || ! empty($ocrResult['members'])) {
                return [
                    'status'  => true,
                    'header'  => $ocrResult['header'],
                    'members' => $ocrResult['members'],
                ];
            }

            return ['status' => false, 'message' => 'Gagal membaca isi file PDF'];
        }

        $lines = array_map('trim', explode("\n", $rawText));
        $lines = array_values(array_filter($lines, function ($l) {
            return $l !== '';
        }));

        $header = [
            'no_kk'          => '',
            'kepala_keluarga' => '',
            'alamat'          => '',
            'rt'              => '',
            'rw'              => '',
            'desa'            => '',
            'kecamatan'       => '',
            'kabupaten'       => '',
            'provinsi'        => '',
            'kode_pos'        => '',
            'tgl_cetak'       => '',
        ];

        // Extract No KK (16 digits after No. or No)
        if (preg_match('/No\.?\s*(\d{16})/', $rawText, $m)) {
            $header['no_kk'] = $m[1];
        } elseif (preg_match('/\b\d{16}\b/', $rawText, $m)) {
            $header['no_kk'] = $m[0];
        }

        // Extract Header fields
        for ($i = 0; $i < count($lines); $i++) {
            $line = $lines[$i];
            if (strpos($line, 'Nama Kepala Keluarga') !== false && isset($lines[$i + 1])) {
                $header['kepala_keluarga'] = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
            }
            if (strpos($line, 'Alamat') !== false && strpos($line, 'RT/RW') === false && isset($lines[$i + 1])) {
                $header['alamat'] = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
            }
            if (strpos($line, 'RT/RW') !== false && isset($lines[$i + 1])) {
                $rtrw  = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
                $parts = explode('/', $rtrw);
                if (count($parts) == 2) {
                    $header['rt'] = trim($parts[0]);
                    $header['rw'] = trim($parts[1]);
                }
            }
            if (strpos($line, 'Desa/Kelurahan') !== false && isset($lines[$i + 1])) {
                $header['desa'] = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
            }
            if (strpos($line, 'Kecamatan') !== false && isset($lines[$i + 1])) {
                $header['kecamatan'] = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
            }
            if (strpos($line, 'Kabupaten/Kota') !== false && isset($lines[$i + 1])) {
                $header['kabupaten'] = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
            }
            if (strpos($line, 'Provinsi') !== false && isset($lines[$i + 1])) {
                $header['provinsi'] = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
            }
            if (strpos($line, 'Kode Pos') !== false && isset($lines[$i + 1])) {
                $header['kode_pos'] = ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t");
            }
            if (strpos($line, 'Dikeluarkan Tanggal') !== false && isset($lines[$i + 1])) {
                $header['tgl_cetak'] = self::formatDate(ltrim($lines[$i + 1], ":\xEF\xBB\xBF\xC2\xA0 \t"));
            }
        }

        // Extract Members Table 1
        $members = [];
        for ($i = 0; $i < count($lines); $i++) {
            if (preg_match('/^\d{16}$/', $lines[$i]) && preg_match('/^\d{1,2}$/', $lines[$i - 2] ?? '')) {
                $no           = $lines[$i - 2];
                $nama         = $lines[$i - 1];
                $nik          = $lines[$i];
                $sex          = $lines[$i + 1] ?? '';
                $tempatlahir  = $lines[$i + 2] ?? '';
                $tanggallahir = self::formatDate($lines[$i + 3] ?? '');
                $agama        = $lines[$i + 4] ?? '';
                $pendidikan   = $lines[$i + 5] ?? '';
                $pekerjaan    = $lines[$i + 6] ?? '';
                if (preg_match('/ANGGOTA\s*LEMBAGA\s*TINGGI/i', $pekerjaan) || preg_match('/LEMBAGA\s*TINGGI\s*LAINNYA/i', $pekerjaan) || preg_match('/PEKERJAAN\s*LAINNYA/i', $pekerjaan)) {
                    $pekerjaan = 'LAINNYA';
                }
                $goldarah     = $lines[$i + 7] ?? '';

                $members[$no] = [
                    'no'             => $no,
                    'nama'           => $nama,
                    'nik'            => $nik,
                    'sex'            => $sex,
                    'tempatlahir'    => $tempatlahir,
                    'tanggallahir'   => $tanggallahir,
                    'agama'          => $agama,
                    'pendidikan'     => $pendidikan,
                    'pekerjaan'      => $pekerjaan,
                    'golongan_darah' => $goldarah,
                ];
            }
        }

        // Extract Members Table 2
        $t2_start = -1;
        for ($i = 0; $i < count($lines); $i++) {
            if (preg_match('/^\(17\)$/', $lines[$i]) || strpos($lines[$i], 'Nama Orang Tua') !== false) {
                $t2_start = $i + 1;
                break;
            }
        }
        if ($t2_start === -1) {
            for ($i = 0; $i < count($lines); $i++) {
                if (self::matchKawin($lines, $i) !== null) {
                    $t2_start = $i - 1;
                    break;
                }
            }
        }

        if ($t2_start !== -1) {
            $t2_lines = array_slice($lines, $t2_start);

            foreach ($members as $no => &$mem) {
                $rowIdx = -1;
                for ($i = 0; $i < count($t2_lines); $i++) {
                    if ($t2_lines[$i] === (string) $no) {
                        for ($j = 1; $j <= 4; $j++) {
                            if (isset($t2_lines[$i + $j]) && (self::matchKawin($t2_lines, $i + $j) !== null || self::matchShdk($t2_lines, $i + $j) !== null)) {
                                $rowIdx = $i;
                                break 2;
                            }
                        }
                    }
                }

                if ($rowIdx !== -1) {
                    $nextNo = (int) $no + 1;
                    $endIdx = count($t2_lines);
                    for ($i = $rowIdx + 1; $i < count($t2_lines); $i++) {
                        if ($t2_lines[$i] === (string) $nextNo || (preg_match('/^\d{1,2}$/', $t2_lines[$i]) && (int) $t2_lines[$i] > (int) $no)) {
                            $endIdx = $i;
                            break;
                        }
                        if (strpos($t2_lines[$i], 'Dikeluarkan Tanggal') !== false) {
                            $endIdx = $i;
                            break;
                        }
                    }

                    $rowTokens = array_slice($t2_lines, $rowIdx + 1, $endIdx - $rowIdx - 1);

                    $status_kawin    = '';
                    $tgl_perkawinan  = '';
                    $shdk            = '';
                    $kewarganegaraan = '';

                    $idx = 0;
                    if ($km = self::matchKawin($rowTokens, $idx)) {
                        $status_kawin = $km['kawin'];
                        $idx += $km['consumed'];
                    }
                    if (isset($rowTokens[$idx]) && preg_match('/^\d{2}-\d{2}-\d{4}$/', $rowTokens[$idx])) {
                        $tgl_perkawinan = self::formatDate($rowTokens[$idx]);
                        $idx++;
                    } elseif (isset($rowTokens[$idx]) && $rowTokens[$idx] === '-' && self::matchShdk($rowTokens, $idx + 1) !== null) {
                        $idx++;
                    }
                    if ($sm = self::matchShdk($rowTokens, $idx)) {
                        $shdk = $sm['shdk'];
                        $idx += $sm['consumed'];
                    }
                    if (isset($rowTokens[$idx]) && in_array(strtoupper(trim($rowTokens[$idx])), ['WNI', 'WNA', 'DUA KEWARGANEGARAAN'])) {
                        $kewarganegaraan = strtoupper(trim($rowTokens[$idx]));
                        $idx++;
                    }

                    $rem = array_slice($rowTokens, $idx);

                    $nama_ayah = '';
                    $nama_ibu  = '';

                    if (count($rem) >= 4) {
                        $nama_ayah = $rem[count($rem) - 2];
                        $nama_ibu  = $rem[count($rem) - 1];
                    } elseif (count($rem) == 3) {
                        $nama_ayah = $rem[1];
                        $nama_ibu  = $rem[2];
                    } elseif (count($rem) == 2) {
                        $nama_ayah = $rem[0];
                        $nama_ibu  = $rem[1];
                    } elseif (count($rem) == 1) {
                        $nama_ibu  = $rem[0];
                    }

                    if ($nama_ayah === '-') {
                        $nama_ayah = '';
                    }
                    if ($nama_ibu === '-') {
                        $nama_ibu = '';
                    }

                    $mem['status_kawin']      = $status_kawin;
                    $mem['tanggalperkawinan'] = $tgl_perkawinan;
                    $mem['hubungan']          = $shdk;
                    $mem['kewarganegaraan']   = $kewarganegaraan;
                    $mem['nama_ayah']         = $nama_ayah;
                    $mem['nama_ibu']          = $nama_ibu;
                }
            }
            unset($mem);
        }

        $hasIstri = false;
        $sharedTglKawin = '';
        foreach ($members as $mem) {
            $hClean = strtoupper(preg_replace('/[^A-Z]/', '', (string) ($mem['hubungan'] ?? '')));
            if ($hClean === 'ISTRI') {
                $hasIstri = true;
            }
            if (in_array($hClean, ['SUAMI', 'ISTRI', 'KEPALAKELUARGA']) && ! empty($mem['tanggalperkawinan'])) {
                $sharedTglKawin = $mem['tanggalperkawinan'];
            }
        }

        foreach ($members as &$mem) {
            $hClean = strtoupper(preg_replace('/[^A-Z]/', '', (string) ($mem['hubungan'] ?? '')));
            if (in_array($hClean, ['SUAMI', 'ISTRI']) || ($hClean === 'KEPALAKELUARGA' && $hasIstri)) {
                if (empty($mem['status_kawin']) || $mem['status_kawin'] === '-' || $mem['status_kawin'] === 'BELUM KAWIN') {
                    $mem['status_kawin'] = 'KAWIN TERCATAT';
                }
                if (empty($mem['tanggalperkawinan']) && ! empty($sharedTglKawin)) {
                    $mem['tanggalperkawinan'] = $sharedTglKawin;
                }
            }
        }
        unset($mem);

        if (empty($header['no_kk']) || empty($members)) {
            $ocrResult = KkScanOcrParser::parseImage($filePath, basename($filePath));
            if (! empty($ocrResult['header']['no_kk']) || ! empty($ocrResult['members'])) {
                return [
                    'status'  => true,
                    'header'  => $ocrResult['header'],
                    'members' => $ocrResult['members'],
                ];
            }
        }

        return [
            'status'  => true,
            'header'  => $header,
            'members' => array_values($members),
        ];
    }

    public static function matchShdk(array $tokens, int $idx): ?array
    {
        if (! isset($tokens[$idx])) {
            return null;
        }

        $t1 = strtoupper(trim((string) $tokens[$idx]));
        $oneClean = preg_replace('/[^A-Z]/', '', $t1);

        // Periksa gabungan 2 token (jika baris terpotong/dibungkus, contoh: "FAMILY" + "LAIN", "KEPALA" + "KELUARGA")
        if (isset($tokens[$idx + 1])) {
            $t2 = strtoupper(trim((string) $tokens[$idx + 1]));
            $twoClean = preg_replace('/[^A-Z]/', '', $t2);

            if (($oneClean === 'FAMILY' || $oneClean === 'FAMILI') && ($twoClean === 'LAIN' || $twoClean === 'LAINNYA')) {
                return ['shdk' => 'FAMILI LAIN', 'consumed' => 2];
            }
            if ($oneClean === 'KEPALA' && $twoClean === 'KELUARGA') {
                return ['shdk' => 'KEPALA KELUARGA', 'consumed' => 2];
            }
            if ($oneClean === 'ORANG' && $twoClean === 'TUA') {
                return ['shdk' => 'ORANG TUA', 'consumed' => 2];
            }
        }

        // Periksa token tunggal (termasuk yang tertulis FAMILY, FAMILI, FAMILY LAIN, FAMILI LAIN, dll)
        if (in_array($oneClean, ['FAMILILAIN', 'FAMILYLAIN', 'FAMILILAINNYA', 'FAMILYLAINNYA', 'FAMILY', 'FAMILI'])) {
            return ['shdk' => 'FAMILI LAIN', 'consumed' => 1];
        }
        if ($oneClean === 'KEPALAKELUARGA') {
            return ['shdk' => 'KEPALA KELUARGA', 'consumed' => 1];
        }
        if ($oneClean === 'SUAMI') {
            return ['shdk' => 'SUAMI', 'consumed' => 1];
        }
        if ($oneClean === 'ISTRI') {
            return ['shdk' => 'ISTRI', 'consumed' => 1];
        }
        if ($oneClean === 'ANAK') {
            return ['shdk' => 'ANAK', 'consumed' => 1];
        }
        if ($oneClean === 'MENANTU') {
            return ['shdk' => 'MENANTU', 'consumed' => 1];
        }
        if ($oneClean === 'CUCU') {
            return ['shdk' => 'CUCU', 'consumed' => 1];
        }
        if ($oneClean === 'ORANGTUA') {
            return ['shdk' => 'ORANG TUA', 'consumed' => 1];
        }
        if ($oneClean === 'MERTUA') {
            return ['shdk' => 'MERTUA', 'consumed' => 1];
        }
        if ($oneClean === 'PEMBANTU' || $oneClean === 'MEMBANTU') {
            return ['shdk' => 'PEMBANTU', 'consumed' => 1];
        }
        if ($oneClean === 'LAINNYA') {
            return ['shdk' => 'LAINNYA', 'consumed' => 1];
        }

        return null;
    }

    public static function matchKawin(array $tokens, int $idx): ?array
    {
        if (! isset($tokens[$idx])) {
            return null;
        }

        $t1 = strtoupper(trim((string) $tokens[$idx]));
        $oneClean = preg_replace('/[^A-Z]/', '', $t1);

        if (in_array($oneClean, ['KAWINTERCATAT', 'KAWINBELUMTERCATAT', 'BELUMKAWIN', 'CERAIHIDUP', 'CERAIMATI', 'CERAITERCATAT', 'CERAIBELUMTERCATAT'])) {
            $map = [
                'KAWINTERCATAT'      => 'KAWIN TERCATAT',
                'KAWINBELUMTERCATAT' => 'KAWIN BELUM TERCATAT',
                'BELUMKAWIN'         => 'BELUM KAWIN',
                'CERAIHIDUP'         => 'CERAI HIDUP',
                'CERAIMATI'          => 'CERAI MATI',
                'CERAITERCATAT'      => 'CERAI TERCATAT',
                'CERAIBELUMTERCATAT' => 'CERAI BELUM TERCATAT',
            ];

            return ['kawin' => $map[$oneClean], 'consumed' => 1];
        }

        if (isset($tokens[$idx + 2])) {
            $t2 = strtoupper(trim((string) $tokens[$idx + 1]));
            $t3 = strtoupper(trim((string) $tokens[$idx + 2]));
            $t2Clean = preg_replace('/[^A-Z]/', '', $t2);
            $t3Clean = preg_replace('/[^A-Z]/', '', $t3);
            if ($t2Clean !== '' && $t3Clean !== '') {
                $threeClean = $oneClean . $t2Clean . $t3Clean;
                if ($threeClean === 'KAWINBELUMTERCATAT') {
                    return ['kawin' => 'KAWIN BELUM TERCATAT', 'consumed' => 3];
                }
                if ($threeClean === 'CERAIBELUMTERCATAT') {
                    return ['kawin' => 'CERAI BELUM TERCATAT', 'consumed' => 3];
                }
            }
        }

        if (isset($tokens[$idx + 1])) {
            $t2 = strtoupper(trim((string) $tokens[$idx + 1]));
            $t2Clean = preg_replace('/[^A-Z]/', '', $t2);
            if ($t2Clean !== '') {
                $twoClean = $oneClean . $t2Clean;
                if ($twoClean === 'KAWINTERCATAT') {
                    return ['kawin' => 'KAWIN TERCATAT', 'consumed' => 2];
                }
                if ($twoClean === 'KAWINBELUMTERCATAT') {
                    return ['kawin' => 'KAWIN BELUM TERCATAT', 'consumed' => 2];
                }
                if ($twoClean === 'BELUMKAWIN') {
                    return ['kawin' => 'BELUM KAWIN', 'consumed' => 2];
                }
                if ($twoClean === 'CERAIHIDUP') {
                    return ['kawin' => 'CERAI HIDUP', 'consumed' => 2];
                }
                if ($twoClean === 'CERAIMATI') {
                    return ['kawin' => 'CERAI MATI', 'consumed' => 2];
                }
                if ($twoClean === 'CERAITERCATAT') {
                    return ['kawin' => 'CERAI TERCATAT', 'consumed' => 2];
                }
                if ($twoClean === 'CERAIBELUMTERCATAT') {
                    return ['kawin' => 'CERAI BELUM TERCATAT', 'consumed' => 2];
                }
            }
        }

        if ($oneClean === 'KAWIN') {
            return ['kawin' => 'KAWIN TERCATAT', 'consumed' => 1];
        }

        return null;
    }

    private static function formatDate($dateStr)
    {
        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', trim($dateStr), $m)) {
            return "{$m[3]}-{$m[2]}-{$m[1]}";
        }

        return null;
    }

    private static function extractRawText($filePath)
    {
        $content = file_get_contents($filePath);
        if (! $content) {
            return '';
        }

        preg_match_all('/stream[\r\n]+(.*?)[\r\n]+endstream/s', $content, $matches);
        $extractedText = '';
        foreach ($matches[1] as $stream) {
            $decompressed = @gzuncompress($stream);
            if (! $decompressed) {
                $decompressed = @gzinflate(substr($stream, 2));
            }
            if (! $decompressed) {
                $decompressed = $stream;
            }

            preg_match_all('/\((?:\\\\.|[^\\\\)]+)*\)\s*T[jJ]|\[(?:(?:\((?:\\\\.|[^\\\\)]+)*\)|[^\]]+)*)\]\s*TJ/s', $decompressed, $tMatches);
            foreach ($tMatches[0] as $tm) {
                preg_match_all('/\((?:\\\\.|[^\\\\)]+)*\)/s', $tm, $strMatches);
                if (! empty($strMatches[0])) {
                    $parts = [];
                    foreach ($strMatches[0] as $s) {
                        $inner   = substr($s, 1, -1);
                        $parts[] = self::unescapePdfString($inner);
                    }
                    $extractedText .= implode('', $parts) . "\n";
                }
            }
        }

        return $extractedText;
    }

    private static function unescapePdfString($str)
    {
        $str = preg_replace_callback('/\\\\([0-7]{1,3})/', static function ($m) {
            return chr(octdec($m[1]));
        }, $str);

        $replacements = [
            '\\('  => '(',
            '\\)'  => ')',
            '\\\\' => '\\',
            '\\r'  => "\r",
            '\\n'  => "\n",
            '\\t'  => "\t",
            '\\b'  => "\b",
            '\\f'  => "\f",
        ];

        return strtr($str, $replacements);
    }
}
