<?php

namespace App\Libraries;

use ZipArchive;
use Exception;
use Throwable;

defined('BASEPATH') || exit('No direct script access allowed');

class GitHubUpdater
{
    public const REPO_OWNER = 'balongbesuk';
    public const REPO_NAME  = 'OpenSIDOCR';
    public const BRANCH     = 'main';

    /**
     * Path ke berkas penyimpan versi lokal git
     */
    protected static function getVersionFilePath(): string
    {
        $dir = FCPATH . 'desa/config/';
        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        return $dir . 'git_version.json';
    }

    /**
     * Ambil informasi commit/versi saat ini di lokal server
     */
    public static function getLocalCommit(): array
    {
        $file = self::getVersionFilePath();
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            if (! empty($data['commit'])) {
                return $data;
            }
        }

        // Coba deteksi dari folder .git jika ada
        $gitDir = FCPATH . '.git';
        if (is_dir($gitDir)) {
            $headFile = $gitDir . '/HEAD';
            if (file_exists($headFile)) {
                $headContent = trim(file_get_contents($headFile));
                if (strpos($headContent, 'ref:') === 0) {
                    $ref = trim(substr($headContent, 4));
                    $refPath = $gitDir . '/' . $ref;
                    if (file_exists($refPath)) {
                        $sha = trim(file_get_contents($refPath));
                        $res = [
                            'commit'    => $sha,
                            'short_sha' => substr($sha, 0, 7),
                            'date'      => date('Y-m-d H:i:s', filemtime($refPath)),
                            'message'   => 'Lokal commit dari .git',
                        ];
                        @file_put_contents($file, json_encode($res, JSON_PRETTY_PRINT));

                        return $res;
                    }
                } else {
                    $res = [
                        'commit'    => $headContent,
                        'short_sha' => substr($headContent, 0, 7),
                        'date'      => date('Y-m-d H:i:s'),
                        'message'   => 'Lokal commit dari .git HEAD',
                    ];
                    @file_put_contents($file, json_encode($res, JSON_PRETTY_PRINT));

                    return $res;
                }
            }
        }

        return [
            'commit'    => 'unknown',
            'short_sha' => 'unknown',
            'date'      => '-',
            'message'   => 'Versi dasar aplikasi',
        ];
    }

    /**
     * Ambil informasi commit terbaru dari GitHub API
     */
    public static function getRemoteCommit(): array
    {
        $apiUrl = sprintf('https://api.github.com/repos/%s/%s/commits/%s', self::REPO_OWNER, self::REPO_NAME, self::BRANCH);

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'OpenSID-GitHub-Updater');
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || ! $response) {
            throw new Exception('Gagal menghubungi GitHub API (HTTP ' . $httpCode . '). Periksa koneksi internet server.');
        }

        $data = json_decode($response, true);
        if (empty($data['sha'])) {
            throw new Exception('Format data repositori GitHub tidak valid.');
        }

        return [
            'commit'    => $data['sha'],
            'short_sha' => substr($data['sha'], 0, 7),
            'date'      => isset($data['commit']['committer']['date']) ? date('Y-m-d H:i:s', strtotime($data['commit']['committer']['date'])) : date('Y-m-d H:i:s'),
            'message'   => trim($data['commit']['message'] ?? ''),
            'author'    => $data['commit']['author']['name'] ?? self::REPO_OWNER,
        ];
    }

    /**
     * Periksa apakah ada pembaruan di GitHub
     */
    public static function checkUpdate(): array
    {
        $local  = self::getLocalCommit();
        $remote = self::getRemoteCommit();

        $hasUpdate = ($local['commit'] === 'unknown') || (substr($local['commit'], 0, 7) !== substr($remote['commit'], 0, 7));

        return [
            'has_update'     => $hasUpdate,
            'local'          => $local,
            'remote'         => $remote,
            'repo'           => self::REPO_OWNER . '/' . self::REPO_NAME,
            'branch'         => self::BRANCH,
        ];
    }

    /**
     * Jalankan proses update aplikasi
     */
    public static function updateNow(): array
    {
        @set_time_limit(600);
        @ini_set('memory_limit', '512M');

        $log = [];
        $log[] = 'Memulai proses pembaruan aplikasi...';

        // 1. Coba update via Git CLI jika tersedia
        $gitDir = FCPATH . '.git';
        if (is_dir($gitDir) && function_exists('shell_exec')) {
            $testGit = @shell_exec('git --version 2>&1');
            if ($testGit && stripos($testGit, 'git version') !== false) {
                $log[] = 'Menggunakan metode Git CLI (cepat)...';
                $pullOutput = @shell_exec('git pull origin ' . escapeshellarg(self::BRANCH) . ' 2>&1');
                $log[] = 'Git: ' . trim((string) $pullOutput);

                if ($pullOutput && (stripos($pullOutput, 'Updating') !== false || stripos($pullOutput, 'Already up to date') !== false || stripos($pullOutput, 'Fast-forward') !== false)) {
                    // Update catatan commit
                    $remote = self::getRemoteCommit();
                    @file_put_contents(self::getVersionFilePath(), json_encode($remote, JSON_PRETTY_PRINT));

                    self::postUpdateTasks($log);

                    return [
                        'status'  => true,
                        'method'  => 'git',
                        'message' => 'Aplikasi berhasil diperbarui via Git ke commit: ' . $remote['short_sha'],
                        'log'     => $log,
                    ];
                }
                $log[] = 'Metode Git CLI tidak dapat menyelesaikan pull, beralih ke metode Pure PHP (Zip Archive)...';
            }
        }

        // 2. Metode Pure PHP (Unduh dan Ekstrak Zip) - Bekerja di semua shared hosting tanpa terminal!
        $log[] = 'Menggunakan metode Pure PHP (Download & Extract Zip)...';
        $tempDir = FCPATH . 'desa/upload/cache/updater_' . time() . '/';
        if (! is_dir($tempDir)) {
            if (! @mkdir($tempDir, 0755, true)) {
                throw new Exception('Gagal membuat folder sementara: ' . $tempDir);
            }
        }

        $zipFile = $tempDir . 'update.zip';
        $zipUrl  = sprintf('https://codeload.github.com/%s/%s/zip/refs/heads/%s', self::REPO_OWNER, self::REPO_NAME, self::BRANCH);

        $log[] = 'Mengunduh paket pembaruan dari GitHub...';
        $fp = fopen($zipFile, 'w+');
        if (! $fp) {
            throw new Exception('Gagal membuat berkas unduhan zip.');
        }

        $ch = curl_init($zipUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'OpenSID-GitHub-Updater');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $downloaded = curl_exec($ch);
        $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);

        if (! $downloaded || $httpCode !== 200 || filesize($zipFile) < 1000) {
            self::removeDir($tempDir);
            throw new Exception('Gagal mengunduh berkas zip dari GitHub (HTTP ' . $httpCode . ').');
        }

        $sizeMb = round(filesize($zipFile) / 1024 / 1024, 2);
        $log[]  = "Paket berhasil diunduh ({$sizeMb} MB). Mengekstrak berkas...";

        $zip = new ZipArchive();
        if ($zip->open($zipFile) !== true) {
            self::removeDir($tempDir);
            throw new Exception('Berkas zip pembaruan rusak atau tidak dapat dibuka.');
        }

        $extractPath = $tempDir . 'extracted/';
        if (! is_dir($extractPath)) {
            @mkdir($extractPath, 0755, true);
        }

        $zip->extractTo($extractPath);
        $zip->close();
        @unlink($zipFile);

        // Cari folder root di dalam zip (misal: OpenSIDOCR-main/)
        $subDirs = glob($extractPath . '*', GLOB_ONLYDIR);
        $sourceDir = ! empty($subDirs) ? $subDirs[0] . '/' : $extractPath;

        $log[] = 'Menyalin berkas sistem ke direktori aplikasi...';
        $copiedCount = self::copyDirectoryRecursive($sourceDir, FCPATH);
        $log[] = "Berhasil memperbarui {$copiedCount} berkas sistem.";

        // Hapus folder sementara
        self::removeDir($tempDir);

        // Catat versi commit baru
        try {
            $remote = self::getRemoteCommit();
            @file_put_contents(self::getVersionFilePath(), json_encode($remote, JSON_PRETTY_PRINT));
        } catch (Throwable $e) {
            // Abaikan jika rate limit
        }

        self::postUpdateTasks($log);

        return [
            'status'  => true,
            'method'  => 'zip',
            'message' => 'Aplikasi berhasil diperbarui ke commit terbaru GitHub!',
            'log'     => $log,
        ];
    }

    /**
     * Jalankan tugas pasca-update: migrasi database & bersihkan cache
     */
    protected static function postUpdateTasks(array &$log): void
    {
        $log[] = 'Memeriksa dan menjalankan pembaruan skema database...';
        try {
            $CI = &get_instance();
            $CI->load->model('database_model');
            if (method_exists($CI->database_model, 'upgrade')) {
                $CI->database_model->upgrade();
                $log[] = 'Pembaruan skema database selesai.';
            }
        } catch (Throwable $e) {
            $log[] = 'Migrasi database: ' . $e->getMessage();
        }

        $log[] = 'Membersihkan cache aplikasi...';
        self::clearAppCache();
        $log[] = 'Pembaruan selesai sepenuhnya!';
    }

    /**
     * Salin berkas secara rekursif dengan proteksi folder penting
     */
    protected static function copyDirectoryRecursive(string $source, string $dest): int
    {
        $count = 0;
        $dir = opendir($source);
        if (! $dir) {
            return 0;
        }

        // Folder dan file yang DILARANG DITIMPA untuk menjaga keutuhan data pengguna
        $protectedPaths = [
            'desa/config',
            'desa/upload',
            'desa/arsip',
            'desa/dokumen',
            '.env',
            '.git',
        ];

        while (($file = readdir($dir)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $srcFile  = $source . $file;
            $destFile = $dest . $file;

            // Periksa relatif path terhadap FCPATH
            $relPath = trim(str_replace([FCPATH, '\\'], ['', '/'], $destFile), '/');

            $isProtected = false;
            foreach ($protectedPaths as $p) {
                if ($relPath === $p || strpos($relPath, $p . '/') === 0) {
                    $isProtected = true;
                    break;
                }
            }

            if ($isProtected) {
                continue;
            }

            if (is_dir($srcFile)) {
                if (! is_dir($destFile)) {
                    @mkdir($destFile, 0755, true);
                }
                $count += self::copyDirectoryRecursive($srcFile . '/', $destFile . '/');
            } else {
                if (@copy($srcFile, $destFile)) {
                    $count++;
                }
            }
        }
        closedir($dir);

        return $count;
    }

    /**
     * Hapus folder rekursif
     */
    protected static function removeDir(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? self::removeDir($path) : @unlink($path);
        }
        @rmdir($dir);
    }

    /**
     * Bersihkan cache aplikasi
     */
    public static function clearAppCache(): void
    {
        $cacheDirs = [
            FCPATH . 'desa/upload/cache/',
            FCPATH . 'donjo-app/cache/',
        ];

        foreach ($cacheDirs as $dir) {
            if (! is_dir($dir)) {
                continue;
            }
            $files = glob($dir . '*');
            foreach ($files as $f) {
                if (is_file($f) && basename($f) !== 'index.html' && basename($f) !== '.htaccess') {
                    @unlink($f);
                }
            }
        }
    }
}
