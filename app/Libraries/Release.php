<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

namespace App\Libraries;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

defined('BASEPATH') || exit('No direct script access allowed');

class Release
{
    /**
     * Api endpoint latest release.
     *
     * @var string
     */
    protected $api;

    /**
     * Lokasi file cache (absolute)
     * Default: [FCPATH]/version.json
     *
     * @var string
     */
    protected $cache;

    /**
     * Interval waktu untuk sinkronisasi ulang data cache dengan yang ada di github.
     * Satuan yang digunakan adalah satuan hari.
     * Default: 7 hari
     *
     * @var int
     */
    protected $interval;

    /**
     * Version
     *
     * @var string
     */
    protected $version;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        if (! $this->cache) {
            $this->setCacheFolder(config_item('cache_path'));
        }

        if (! $this->interval) {
            $this->interval = (ENVIRONMENT == 'development') ? 3600 : (1 * 86400);
        }
    }

    /**
     * Set URL endpoint API yang ingin di hit.
     *
     * return $this
     */
    public function setApiUrl(string $url)
    {
        $this->api = $url;

        return $this;
    }

    /**
     * Set interval waktu sinkronisasi cache dengan repo github.
     * Defaultnya 1 hari sekali akan dilakukan pembaruan cache.
     * Gunakan ini jika ingin mengubah interval sinkronisasinya.
     *
     * return $this
     */
    public function setInterval(int $interval)
    {
        $this->interval = max(3600, $interval * 86400); // Minimal 3600 detik (1 jam)

        return $this;
    }

    /**
     * Set lokasi folder cache.
     * Misalkan diisi 'desa/config' maka file cache akan
     * disimpan di [FCPATH]/desa/config/version.json
     * Jika folder tidak ditemukan atau tidak writable
     * maka akan fallback ke path default (FCPATH/version.json)
     *
     * return $this
     */
    public function setCacheFolder(?string $folder = null)
    {
        if (empty($folder)) {
            $folder = FCPATH . 'desa' . DIRECTORY_SEPARATOR . 'cache';
        }

        if (! is_dir($folder)) {
            @mkdir($folder, 0755, true);
        }

        if (! is_dir($folder) || ! is_writable($folder)) {
            $folder = FCPATH;
        }

        $this->cache = rtrim($folder, '/\\') . DIRECTORY_SEPARATOR . 'version.json';

        return $this;
    }

    /**
     * Cek apakah ada rilis baru atau tidak.
     * Caranya dengan membandingkan versi saat ini dengan versi yang ada di repositori.
     *
     * @return bool
     */
    public function isAvailable()
    {
        $res = $this->resync();
        if (! $res || empty($res->tag_name)) {
            return false;
        }

        $latestVer = $this->fixVersioning($res->tag_name);
        $currVer   = $this->fixVersioning($this->getCurrentVersion());

        return $latestVer > 0 && $currVer < $latestVer;
    }

    /**
     * Atur versi yang digunakan saat ini
     * Contoh return value: 'v2304.0.0'
     *
     * return $this
     */
    public function setCurrentVersion(?string $version = null)
    {
        $this->version = 'v' . ltrim($version ?? VERSION, 'v');

        return $this;
    }

    /**
     * Ambil versi
     *
     * @return string
     */
    public function getCurrentVersion()
    {
        return $this->version;
    }

    /**
     * Ambil tag versi dari rilis terbaru.
     * Contoh return value: 'v2304.0.1'
     *
     * @return string
     */
    public function getLatestVersion()
    {
        $res = $this->resync();

        return ($res && ! empty($res->tag_name)) ? $res->tag_name : '';
    }

    /**
     * Ambil nama rilis
     * Contoh return value di rilis v20.07:
     *  'Sediakan QR Code dan masukkan APBDes secara manual'
     *
     * @return string
     */
    public function getReleaseName()
    {
        $res = $this->resync();

        return ($res && ! empty($res->name)) ? $res->name : '';
    }

    /**
     * Ambil url download rilis
     *
     * @return string
     */
    public function getReleaseDownload()
    {
        $res = $this->resync();
        if (! $res || empty($res->html_url)) {
            return '';
        }

        return str_replace('releases/tag', 'archive/refs/tags', $res->html_url) . '.zip';
    }

    /**
     * Ambil deskripsi rilis (github menamainya body).
     * Contoh return value di rilis v20.07:
     * 'Di rilis ini, versi 20.07, tersedia fitur untuk membuat file QR Code yg bisa dipasang di artikel,
     * surat atau materi lain. Rilis ini juga berisi perbaikan lain yang diminta Komunitas SID ... dst.'
     *
     * @return string
     */
    public function getReleaseBody()
    {
        $res = $this->resync();
        if (! $res || empty($res->body)) {
            return '';
        }

        return $this->convertMarkdownLink($res->body);
    }

    /**
     * Convert markdown link ke html.
     *
     * @see https://stackoverflow.com/questions/24985530/parsing-a-markdown-style-link-safely
     *
     * @return string
     */
    protected function convertMarkdownLink(?string $body = null)
    {
        return preg_replace_callback('/\[(.*?)\]\((https?:\/\/[^\s"\'>]+)\)/i', static fn ($matches) => '<a href="' . $matches[2] . '" target="_blank" rel="noopener noreferrer">' . $matches[1] . '</a>', htmlspecialchars($body));
    }

    /**
     * Sinkronisasi file cache dengan data di repositori.
     *
     * @return object
     */
    public function resync()
    {
        if (! $this->api) {
            throw new Exception('Please specify the API endpoint URL.');
        }

        if ($this->cacheIsOutdated()) {
            try {
                $client   = new Client();
                $response = $client->get($this->api, [
                    'headers' => [
                        'Accept'     => 'application/vnd.github.v3+json',
                        'User-Agent' => 'OpenSIDOCR',
                    ],
                    'verify'  => false,
                    'timeout' => 5,
                ]);

                if ($response->getStatusCode() == 200) {
                    $contents = $response->getBody()->getContents();
                    $this->writeRaw($contents);

                    return json_decode($contents, null, 512, JSON_THROW_ON_ERROR);
                }
            } catch (ClientException $cx) {
                // Jika 404 pada releases/latest, GitHub tidak menemukan rilis full/official.
                // Coba fallback ke endpoint /releases untuk membaca rilis (termasuk pre-release).
                if ($cx->getResponse() && $cx->getResponse()->getStatusCode() === 404 && strpos($this->api, '/releases/latest') !== false) {
                    try {
                        $fallbackUrl = str_replace('/releases/latest', '/releases', $this->api);
                        $resFallback = $client->get($fallbackUrl, [
                            'headers' => [
                                'Accept'     => 'application/vnd.github.v3+json',
                                'User-Agent' => 'OpenSIDOCR',
                            ],
                            'verify'  => false,
                            'timeout' => 5,
                        ]);

                        if ($resFallback->getStatusCode() === 200) {
                            $items = json_decode($resFallback->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);
                            if (is_array($items) && ! empty($items)) {
                                $latest = $items[0];
                                $this->writeRaw(json_encode($latest, JSON_PRETTY_PRINT));

                                return $latest;
                            }
                        }
                    } catch (\Throwable $t) {
                        // fallback gagal
                    }
                }

                // Jangan catat 404 sebagai error fatal di error log karena repo tanpa full release adalah hal yang normal
                if ($cx->getResponse() && $cx->getResponse()->getStatusCode() === 404) {
                    log_message('notice', 'Release notice: endpoint ' . $this->api . ' tidak ditemukan (404 Not Found). Belum ada full release di repositori.');
                } else {
                    log_message('error', 'Release client exception: ' . $cx->getMessage());
                }
                $this->setFailureCooldown();
            } catch (Exception $e) {
                log_message('error', 'Release exception: ' . $e->getMessage());
                $this->setFailureCooldown();
            }
        }

        try {
            $cachedContent = $this->read();
            if (! $cachedContent) {
                return false;
            }

            $data = json_decode($cachedContent, null, 512, JSON_THROW_ON_ERROR);
            if (! empty($data->url) && strpos($this->api, 'balongbesuk/OpenSIDOCR') !== false && strpos($data->url, 'balongbesuk/OpenSIDOCR') === false) {
                return false;
            }

            return $data;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());

            return false;
        }
    }

    /**
     * Terapkan cooldown/jeda sementara jika request ke API gagal (misal 403 Rate Limit atau koneksi putus).
     * Mencegah aplikasi melakukan spam request di setiap kali halaman dibuka.
     *
     * @param int $cooldownSeconds Default 3600 detik (1 jam)
     */
    protected function setFailureCooldown(int $cooldownSeconds = 3600): void
    {
        $targetMtime = time() - $this->interval + $cooldownSeconds;

        if (is_file($this->cache)) {
            @touch($this->cache, $targetMtime);
        } else {
            $placeholder = json_encode([
                'tag_name'  => '',
                'name'      => '',
                'body'      => '',
                'html_url'  => '',
                'error'     => 'failed_or_rate_limited',
                'cached_at' => time(),
            ], JSON_PRETTY_PRINT);

            $this->writeRaw($placeholder);
            @touch($this->cache, $targetMtime);
        }
    }

    /**
     * Cek apakah data cache sudah kadaluwarsa atau belum.
     * Cache dianggap kadaluwarsa jika:
     *   - File cachenya belum ada di server kita, atau
     *   - File cache sudah ada tetapi waktu modified-time filenya sudah
     *     lebih dari interval yang ditentukan.
     *
     * @return bool
     */
    public function cacheIsOutdated()
    {
        return ! is_file($this->cache) || (time() > (filemtime($this->cache) + $this->interval));
    }

    /**
     * Ubah versi rilis menjadi integer agar bisa dibandingkan
     *
     * Contoh : 2304.0.0 => 230400000000
     *
     * @return int
     */
    public function fixVersioning(?string $version = null)
    {
        $version = str_replace('v', '', $version);
        $version = explode('.', $version);

        // major, minor dan patch maksimal 4 digit
        $major = (int) substr($version[0] ?? '0', 0, 4) * 100_000_000;
        $minor = (int) substr($version[1] ?? '0', 0, 4) * 10000;
        $patch = (int) substr($version[2] ?? '0', 0, 4);

        return $major + $minor + $patch;
    }

    /**
     * Tulis konten cache secara langsung ke file cache.
     *
     * @return bool
     */
    public function writeRaw(string $cache): bool
    {
        $dir = dirname($this->cache);
        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        return (bool) file_put_contents($this->cache, $cache, LOCK_EX);
    }

    /**
     * Buat/timpa file cache jika sudah kadaluwarsa.
     *
     * @return void
     */
    public function write(string $cache)
    {
        if ($this->cacheIsOutdated()) {
            $this->writeRaw($cache);
        }
    }

    /**
     * Baca file cache.
     *
     * @return string
     */
    public function read()
    {
        if (! is_file($this->cache)) {
            return '';
        }

        return (string) file_get_contents($this->cache);
    }
}
