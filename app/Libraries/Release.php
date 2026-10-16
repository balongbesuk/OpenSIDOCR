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
            $this->setInterval(ENVIRONMENT == 'development' ? 0 : 7);
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
     * Defaultnya 7 hari sekali akan dilakukan pembaruan cache.
     * Gunakan ini jika ingin mengumbah interval sinkronisasinya.
     *
     * return $this
     */
    public function setInterval(int $interval)
    {
        $this->interval = $interval * 86400; // N * 86400 detik (1 hari)

        return $this;
    }

    /**
     * Set lokasi folder cache.
     * Misalkan diisi 'desa/config' maka file cache akan
     * disimpan di [FCPATH]/desa/config/version.json
     * Jika folder tidak ditemuakan atau tidak writable
     * maka akan fallback ke path default (FCPATH/version.json)
     *
     * return $this
     */
    public function setCacheFolder(string $folder)
    {
        $folder = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $folder);
        $folder = str_replace(FCPATH, '', $folder);
        $folder = trim($folder, DIRECTORY_SEPARATOR);

        if (! is_dir($folder) || ! is_writable($folder)) {
            $folder = FCPATH;
        } else {
            $folder = FCPATH . $folder . DIRECTORY_SEPARATOR;
        }

        $this->cache = $folder . 'version.json';

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
        return preg_replace_callback('/\[(.*?)\]\((.*?)\)/', static fn ($matches) => '<a href="' . $matches[2] . '">' . $matches[1] . '</a>', htmlspecialchars($body));
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
                    'verify' => false,
                ]);

                if ($response->getStatusCode() == 200) {
                    $contents = $response->getBody()->getContents();
                    $this->write($contents);

                    return json_decode($contents, null, 512, JSON_THROW_ON_ERROR);
                }
            } catch (ClientException $cx) {
                log_message('error', 'Release client exception: ' . $cx->getMessage());

                return false;
            } catch (Exception $e) {
                log_message('error', 'Release exception: ' . $e->getMessage());

                return false;
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
        $major = (int) substr($version[0], 0, 4) * 100_000_000;
        $minor = (int) substr($version[1], 0, 4) * 10000;
        $patch = (int) substr($version[2], 0, 4);

        return $major + $minor + $patch;
    }

    /**
     * Buat/timpa file cache jika sudah kadaluwarsa.
     *
     * @return void
     */
    public function write(string $cache)
    {
        $file = $this->cache;

        if ($this->cacheIsOutdated()) {
            if (is_file($file)) {
                unlink($file);
            }

            file_put_contents($file, $cache, LOCK_EX);
        }
    }

    /**
     * Baca file cache.
     *
     * @return string
     */
    public function read()
    {
        return file_get_contents($this->cache);
    }
}
