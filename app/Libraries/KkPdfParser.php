<?php

namespace App\Libraries;

class KkPdfParser
{
    public static function parseFile($filePath)
    {
        $rawText = self::extractRawText($filePath);
        if (empty($rawText)) {
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
        for ($i = 0; $i < count($lines); $i++) {
            if (in_array($lines[$i], ['KAWIN TERCATAT', 'KAWIN', 'BELUM KAWIN', 'CERAI HIDUP', 'CERAI MATI']) && preg_match('/^\d{1,2}$/', $lines[$i - 1] ?? '')) {
                $no = $lines[$i - 1];
                if (isset($members[$no])) {
                    $status_kawin   = $lines[$i];
                    $idx            = $i + 1;
                    $tgl_perkawinan = '';
                    if (isset($lines[$idx]) && preg_match('/^\d{2}-\d{2}-\d{4}$/', $lines[$idx])) {
                        $tgl_perkawinan = self::formatDate($lines[$idx]);
                        $idx++;
                    } elseif (isset($lines[$idx]) && $lines[$idx] === '-') {
                        $idx++;
                    }

                    $shdk = $lines[$idx] ?? '';
                    $idx++;
                    $kewarganegaraan = $lines[$idx] ?? '';
                    $idx++;

                    while (isset($lines[$idx]) && $lines[$idx] === '-') {
                        $idx++;
                    }

                    $nama_ayah = $lines[$idx] ?? '';
                    $idx++;
                    $nama_ibu = $lines[$idx] ?? '';

                    $members[$no]['status_kawin']      = $status_kawin;
                    $members[$no]['tanggalperkawinan'] = $tgl_perkawinan;
                    $members[$no]['hubungan']          = $shdk;
                    $members[$no]['kewarganegaraan']   = $kewarganegaraan;
                    $members[$no]['nama_ayah']         = $nama_ayah;
                    $members[$no]['nama_ibu']          = $nama_ibu;
                }
            }
        }

        return [
            'status'  => true,
            'header'  => $header,
            'members' => array_values($members),
        ];
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
