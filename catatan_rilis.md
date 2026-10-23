Aplikasi **OpenSIDOCR** merupakan pengembangan lanjutan dari **OpenSID versi 2403.0.0** dan seterusnya oleh Pemerintah Desa Balongbesuk ([balongbesuk/OpenSIDOCR](https://github.com/balongbesuk/OpenSIDOCR)).

---

### Rilis v1.2.2 (Pemetaan Pekerjaan Dukcapil Impor KK & Perbaikan Stabilitas Periksa Database)

Rilis perbaikan dan peningkatan pada modul impor data kependudukan dan penanganan galat sistem:

#### Peningkatan & Perbaikan BUG

1. **Pemetaan Otomatis Pekerjaan Dukcapil KK ke Kategori "LAINNYA":**
   - Menambahkan pemetaan jenis pekerjaan Dukcapil `"ANGGOTA LEMBAGA TINGGI LAINNYA"` (dan variasinya) ke kategori `"LAINNYA"` (ID 89) pada modul pembaca PDF (`KkPdfParser`), OCR scan (`KkScanOcrParser`), serta tampilan pratinjau dan fungsi penyimpanan KK pada controller `Keluarga`.
   - Mengeliminasi peringatan perbedaan (*diff*) palsu pada halaman pratinjau dan mencegah status pekerjaan warga keliru tersimpan sebagai *"BELUM/TIDAK BEKERJA"*.

2. **Pengarsipan Dokumen KK yang Lebih Tangguh (*Fail-safe*):**
   - Menambahkan mekanisme penentuan ID cadangan (`max(id) + 1`) pada proses pengarsipan file KK elektronik ke tabel `dokumen` untuk mengantisipasi database tanpa atribut auto-increment.

3. **Perbaikan Fatal Error HTTP 500 pada Halaman Periksa/Login di PHP 8.2:**
   - Mendeklarasikan properti dan menginisialisasi `$this->setting = new \stdClass()` pada controller `Periksa`.
   - Menghilangkan galat fatal PHP 8.2 `Attempt to assign property "sebutan_desa" on null` saat sistem mendiagnosa periksa data.

4. **Pencegahan Bentrok Sesi Login Ganda pada Halaman Periksa:**
   - Mengizinkan administrator yang sudah terautentikasi untuk langsung mengakses halaman `/periksa` tanpa dipaksa login ulang yang memicu proteksi *single-session* ("Akun sedang aktif di perangkat lain").
   - Memperbaiki pengecekan sesi aktif pada `User_model::siteman()` agar mengenali sesi peramban yang sama (`$isCurrentSession`) sehingga re-autentikasi tidak memicu false positive.

---

### Rilis v1.2.1 (Patch Keamanan IDOR, Stabilitas Login PHP 8.2 & Lean Code Cleanup)

Rilis perbaikan (*security & stability patch*) berdasarkan hasil audit mendalam Ponytail: perbaikan celah keamanan akses arsip surat (IDOR), mitigasi fatal error TypeError pada fungsi hash PIN di PHP 8.2, penanganan null-safety saat NIK tidak terdaftar, pencegahan unhandled exception pada printer anjungan, proteksi DoS pada script instalasi OCR, serta pembersihan ribuan baris kode sampah (*dead code*).

#### Perbaikan Keamanan & BUG

1. **Penutupan Celah Keamanan IDOR pada Unduh Arsip Surat Warga:**
   - Menambahkan verifikasi kepemilikan dokumen pada method `Surat::cetak($id)` di `donjo-app/controllers/fmandiri/Surat.php`.
   - Memastikan hanya warga yang berhak (`(int) $surat->id_pend === (int) $this->is_login->id_pend`) yang dapat mengunduh berkas surat arsip, mencegah manipulasi ID dokumen untuk mengintip surat rahasia warga lain.

2. **Perbaikan Fatal Error TypeError pada `hash_pin()` di PHP 8.2:**
   - Memperbaiki fungsi `hash_pin()` pada `donjo-app/helpers/donjolib_helper.php` agar aman terhadap nilai string kosong (`""`) dan melakukan typecasting integer eksplisit `(int) strrev((string) $pin) * 77`.
   - Mengeliminasi fatal error `TypeError: Unsupported operand types: string * int` ketika form login disubmit tanpa PIN.

3. **Penanganan Null-Safety pada Login Mandiri (`siteman` & `siteman_ektp`):**
   - Menambahkan pengecekan `if (! $data)` sebelum mengakses properti `$data->id_pend` dan `$data->aktif` pada `donjo-app/models/Mandiri_model.php`.
   - Menghilangkan error PHP 8.x `Attempt to read property on null` saat pengguna salah memasukkan NIK atau RFID card yang belum terdaftar di database.

4. **Penanganan Error Printer Anjungan (*Kiosk Printer Finally Block*):**
   - Inisialisasi `$printer = null` dan penambahan pengecekan `if ($printer)` sebelum memanggil `$printer->close()` pada method `Surat::cetak_no_antrian()` di `donjo-app/controllers/fmandiri/Surat.php`.
   - Mencegah fatal crash saat printer thermal anjungan sedang mati / offline.

5. **Peningkatan Keamanan & Deteksi Pintar pada `install_ocr.php`:**
   - Menambahkan deteksi otomatis status engine RapidOCR & ONNX Runtime (multi-platform Windows/Linux): tombol unduh & pasang otomatis disembunyikan jika engine sudah aktif terpasang.
   - Menambahkan dialog **Popup Modal Otomatis Wajib** saat halaman dibuka jika engine terdeteksi sudah aktif, yang mewajibkan penekanan tombol **Hapus File `install_ocr.php`** (`unlink`) tanpa opsi lewati demi keamanan mutlak server desa.
   - Membatasi eksekusi instalasi pip hanya melalui metode HTTP `POST` dengan tombol konfirmasi eksplisit untuk mencegah bot/crawler memicu loop instalasi yang menghabiskan CPU/RAM server.

6. **Optimasi Performa Query Skema & Kehadiran (Tanpa Mengubah Struktur Database):**
   - Men-cache pengecekan skema kolom tabel `anjungan`, tabel `pesan`/`pesan_detail`, dan kolom `log_surat` per sesi di `donjo-app/core/MY_Controller.php`.
   - Membatasi eksekusi `cek_kehadiran()` secara berkala (tiap 10 menit), mengeliminasi query `SHOW TABLES` dan `SHOW COLUMNS` berulang pada setiap pemuatan halaman tanpa mengubah tabel database sama sekali.

#### Pembersihan Kode Mati (*Lean Code Cleanup*)

1. Menghapus berkas duplikat `assets/filemanager/UploadHandlerAsli.php` (-1.596 baris kode).
2. Menghapus fungsi helper tidak terpakai `UploadGambarWidget()` pada `donjo-app/helpers/pict_helper.php`.
3. Membersihkan seluruh 17 berkas cadangan `.bak` pada direktori `donjo-app/controllers/fmandiri/` dan `donjo-app/views/fmandiri/`.

---

### Rilis v1.2.0 (Modernisasi UI Layanan Mandiri, Redesain Survei Kepuasan & Integrasi Cetak Dokumen In-App)

Rilis ini memuat modernisasi antarmuka pengguna (UI/UX) pada modul Layanan Mandiri, pembaruan popup penilaian survei kepuasan warga saat keluar akun, serta integrasi pratinjau dan pencetakan dokumen kependudukan (Biodata dan Salinan Kartu Keluarga) langsung di dalam bingkai aplikasi tanpa membuka tab baru.

#### Penambahan Fitur & Peningkatan

1. **Integrasi Penuh Cetak Dokumen di Dalam Aplikasi Layanan Mandiri (In-App Document Viewer):**
   - Halaman **Cetak Biodata Penduduk** (`/layanan-mandiri/cetak-biodata`) dan **Cetak Salinan Kartu Keluarga** (`/layanan-mandiri/cetak-kk`) kini dimuat langsung di dalam bingkai antarmuka Layanan Mandiri menggunakan layout terpadu (`Mandiri_Controller::render()`).
   - Penghapusan atribut `target="_blank"` pada tombol cetak di sidebar menu, halaman profil, dan dashboard beranda sehingga pengguna tidak lagi diarahkan membuka tab baru terpisah di peramban.
   - Penambahan **Action Toolbar** di bagian atas lembar pratinjau dokumen dengan navigasi breadcrumb, tombol **"Kembali"**, dan tombol **"Cetak Dokumen"** (`window.print()`).
   - Penataan lembar dokumen resmi standar A4 yang proporsional, bersih, dan profesional.
   - Penerapan aturan cetak presisi scoped `@media print`: saat mencetak lembar atau menyimpan ke PDF (`Ctrl + P`), seluruh elemen navigasi antarmuka (sidebar, header akun, action toolbar, mobile bottom dock) disembunyikan secara otomatis, menghasilkan cetakan formulir resmi yang bersih.
   - Dukungan fallback parameter `?raw=1` untuk kebutuhan kompatibilitas pratinjau cetak polos bawaan.

2. **Redesain Popup Survei Kepuasan Layanan Mandiri (`#pendapat`):**
   - Perombakan total dialog modal survei kepuasan warga saat hendak keluar dari akun Layanan Mandiri dengan konsep *modern card dialog* dan sentuhan *ambient color glow stripe*.
   - Tipografi yang lebih ramah dengan icon badge bintang emas dan petunjuk yang informatif.
   - Peningkatan visual emotikon pilihan kepuasan (Sangat Puas, Puas, Cukup, Buruk) menggunakan ilustrasi ekspresif yang proporsional.
   - Sinkronisasi aset ikon survei di modul admin Pendapat (`assets/images/layanan_mandiri/`).
   - **Optimasi Tombol Aksi Mobile**: Penataan ulang tombol "Tetap di Sini" dan "Lewati & Keluar" pada perangkat ponsel/mobile menjadi berdampingan secara horizontal (*side-by-side* / kiri-kanan) melalui `grid grid-cols-2`, menghilangkan susunan bertumpuk vertikal yang kurang ergonomis.

#### Perubahan Teknis

1. Pembaruan controller `donjo-app/controllers/fmandiri/Beranda.php` pada fungsi `cetak_biodata()` dan `cetak_kk()` untuk merender view kependudukan ke dalam layout utama Layanan Mandiri (`fmandiri/template`).
2. Pembuatan template view in-app baru `donjo-app/views/fmandiri/cetak_biodata.php` dan perombakan `donjo-app/views/fmandiri/cetak_kk.php`.
3. Penyesuaian layout container `donjo-app/views/fmandiri/template.php` untuk menyembunyikan welcome banner & kartu metrik pada rute pencetakan dokumen serta penerapan CSS print global.
4. Pembaruan modal `donjo-app/views/fmandiri/pendapat.php` dan aset gambar terkait pada `assets/images/layanan_mandiri/`.
5. Pengujian kompatibilitas penuh: Seluruh fungsi terverifikasi berjalan lancar dan bebas error pada **PHP 7.4** maupun **PHP 8.2**.

---

### Rilis v1.1.0 (Dukungan PHP 8.2 & Penguatan Kompatibilitas Sistem)

Rilis ini memuat dukungan penuh lingkungan PHP 8.2 (Dual-Support PHP 7.4 & PHP 8.2) serta perbaikan kompatibilitas menyeluruh pada tema publik dan 20 kelompok modul Panel Admin.

#### Penambahan Fitur & Peningkatan

1. **Dukungan Penuh Dual-PHP (PHP 7.4 & PHP 8.2):**
   - Pembaruan arsitektur kode aplikasi agar sepenuhnya kompatibel dijalankan pada PHP 8.2 maupun PHP 7.4 secara fleksibel tanpa memerlukan konfigurasi ulang kode saat server di-upgrade.

#### Perbaikan BUG & Kompatibilitas PHP 8.2

1. **Perbaikan Halaman Blank Status Desa (`/status_desa` - IDM & SDGs):**
   - Perbaikan fatal error `Undefined constant "INDIKATOR"` pada `resources/views/admin/status_desa/idm.blade.php`.
   - Perbaikan fatal error `Cannot use object of type stdClass as array` pada `donjo-app/helpers/general_helper.php` dan `header.blade.php`.
   - Perbaikan fatal error `Class "Client" not found` pada helper `opensid_helper.php` dan controller `Status_desa.php` menggunakan namespace global `\GuzzleHttp\Client`.
   - Penanganan null-safe pada properti `$idm->error_msg`, `$sdgs->error_msg`, dan penambahan fallback variabel `$header` pada `sdgs.blade.php`.
2. **Perbaikan Kompatibilitas Tema Website Publik:**
   - Perbaikan TypeError `count(): Argument #1 ($value) must be of type Countable|array, null given` pada 12 berkas tema website desa (`template.php`, `slider.php`, arsip, artikel, widget) dengan beralih ke pengecekan `!empty()`.
3. **Perbaikan Modul Statistik Kependudukan & Laporan Rentan:**
   - Perbaikan fatal error `Undefined constant "id"` pada tautan data rincian `donjo-app/views/statistik/penduduk.php` (`$data[id]` diganti menjadi `$data['id']`).
   - Perbaikan fatal error `Unsupported operand types: string + int` pada `donjo-app/views/laporan/kelompok.php`, `kelompok_excel.php`, dan `kelompok_print.php` akibat penimpaan variabel akumulator `$cacat` oleh loop `foreach ($jenis_cacat as $key => $cacat)`.
4. **Perbaikan Modul Dokumen Sekretariat & Pengaturan Grup:**
   - Perbaikan fatal error `Undefined constant "id"` pada berkas `donjo-app/views/dokumen/table.php`, `donjo-app/views/dokumen/table_dokumen.php`, dan `donjo-app/views/grup/table.php`.
5. **Perbaikan Seluruh Submenu Modul Analisis (8 Submenu):**
   - Perbaikan TypeError `count(): Argument #1 must be Countable, null given` saat `$list_error` bernilai null pada modal impor analisis `donjo-app/views/analisis_master/modal_hasil_import.php` yang sebelumnya menyebabkan seluruh submenu analisis gagal dimuat.
6. **Perbaikan Pembagian Nol (DivisionByZeroError) pada Modul Lapak, Pengaduan, & Pendapat:**
   - Penambahan proteksi `!empty($total)` pada perhitungan persentase progres bar di `donjo-app/views/lapak_admin/navigasi.php`, `donjo-app/views/pengaduan_admin/navigasi.php`, dan `donjo-app/views/pendapat/index.php` saat data masih bernilai nol (0).
7. **Perbaikan Admin Web / Artikel (`/web`):**
   - Perbaikan fatal error `Non-static method App\Models\UserGrup::getGrupSistem() cannot be called statically` dengan menambahkan deklarasi `public static function getGrupSistem()` pada model `App\Models\UserGrup`.
8. **Perbaikan Halaman Statistik Pengunjung (`/pengunjung`):**
   - Penyesuaian typehint `function getBulan($bln)` pada `donjolib_helper.php` agar kompatibel menerima nilai string numerik maupun integer tanpa memicu TypeError.
9. **Perbaikan Deadlock Server & Kueri MySQL 8.4 pada Modul Pendapat:**
   - Penanganan loopback deadlock pada helper `to_base64()` di `donjo-app/helpers/pict_helper.php`: konversi otomatis URL localhost ke path filesystem lokal `FCPATH` untuk mencegah server terkunci saat membaca aset internal.
   - Perbaikan kueri filter tanggal MySQL 8.4 pada `donjo-app/models/Pendapat_model.php` dari sintaks tidak valid `tanggal != 'NOT NULL'` menjadi kueri datetime standar `DATE(tanggal) >= '1970-01-01'`.
10. **Perbaikan Null-Safety pada Admin Controller:**
    - Penanganan akses properti aman pada `$this->session->isAdmin->pamong` dan query pengguna pada `MY_Controller.php` dan `User_model.php` untuk mencegah fatal error `Attempt to read property on null`.

#### Perubahan Teknis

1. Refaktor helper `to_base64()` pada `pict_helper.php` dengan deteksi URL internal ke direktori `FCPATH` untuk mencegah request HTTP loopback yang mengunci server.
2. Penambahan deklarasi `static` pada method `App\Models\UserGrup::getGrupSistem()` agar sesuai standar OOP PHP 8.x.
3. Penyesuaian strict types pada helper penanggalan `getBulan()` di `donjolib_helper.php` untuk menerima parameter integer maupun string numerik.
4. Standardisasi kueri datetime pada `Pendapat_model.php` untuk kompatibilitas penuh dengan MySQL 8.x LTS.
5. Verifikasi menyeluruh: Seluruh 82 submenu admin pada 20 modul terverifikasi lulus uji (HTTP 200 OK) serta 100% kompatibel ganda (*dual-support*) pada PHP 8.2 maupun PHP 7.4.

---

### Rilis v1.0.0 (Dukungan PHP 7.4 & AI RapidOCR)

Rilis awal ini memuat fitur kecerdasan buatan (AI RapidOCR) Kartu Keluarga, reaktivasi & pembenahan surat RTF, pembaruan otomatis dari repositori GitHub, serta modernisasi UI Layanan Mandiri dan Panel Admin.

#### Penambahan Fitur

1. Penambahan pemetaan otomatis pekerjaan Dukcapil "APARATUR SIPIL NEGARA (ASN)" ke PEGAWAI NEGERI SIPIL (PNS) pada impor KK PDF.
2. Penambahan pembersihan otomatis data isian jalan/alamat pada impor KK PDF jika sama atau hampir sama dengan nama dusun agar tidak mengulang nama dusun.
3. Reaktivasi penambahan format surat RTF pada Pengaturan Surat (tombol Tambah Surat RTF, form pembuatan surat RTF, inisialisasi otomatis folder dan berkas template).
4. Peningkatan fitur Impor Kartu Keluarga dari scan / foto / PDF menggunakan AI RapidOCR (PP-OCRv4 Latin) dengan auto-deskew, pemrosesan kontras cerdas (OpenCV CLAHE), dan deteksi otomatis berkas PDF scan.
5. Penambahan URL SEO-friendly untuk statistik kependudukan (`/data-statistik/{slug}`), pemetaan slug otomatis dari enum statistik, dan penyesuaian rute `/daftar-pemilih-tetap`, `/dpt`, serta `/perkembangan-penduduk`.
6. Penambahan fitur Filter Wilayah bertingkat (Dusun, RW, RT) dengan pembaruan dinamis (AJAX) pada halaman data statistik publik.
7. Penambahan format cetak laporan statistik resmi berstandar A4 dengan Kop Surat Pemerintahan Desa, cakupan filter wilayah, dan lembar pengesahan tanda tangan Kepala Desa.
8. Penambahan halaman portal indeks statistik desa (`/data-statistik`) dengan ringkasan data kependudukan (Quick Stats), kartu indikator statistik yang terintegrasi hak akses menu aktif OpenSID, serta fitur pencarian dan filter kategori indikator secara realtime.
9. Penambahan dashboard terpadu Beranda Layanan Mandiri (`/layanan-mandiri/beranda`) yang memuat ringkasan permohonan surat terkini beserta status & no antrean, kotak pesan masuk dari desa, data profil kependudukan warga, status verifikasi keamanan ganda (Telegram & Email), informasi kontak darurat, serta jadwal jam layanan operasional kantor desa.
10. Redesain modern UI/UX Layanan Mandiri berbasis sistem antarmuka responsif (mobile & desktop), kartu aksi cepat (Quick Actions), penataan formulir permohonan surat, pratinjau dokumen, profil kependudukan, dan fitur ganti PIN yang lebih interaktif.
11. Penambahan sistem notifikasi otomatis ke kotak pesan Layanan Mandiri warga ketika status permohonan surat diperbarui oleh petugas desa (sedang diperiksa, menunggu tandatangan, siap diambil, selesai, atau perlu dilengkapi).
12. Optimasi antarmuka navbar admin pada tampilan mobile menjadi 1 bar terpadu (50px) dengan logo/judul OpenSID di tengah, menu hamburger di sebelah kiri, penyesuaian ukuran foto profil pengguna lebih proporsional, penggabungan menu notifikasi/layanan cepat dan informasi ke dalam dropdown profil, serta koordinasi otomatis peralihan antara menu hamburger dan sidebar informasi (ketika sidebar informasi terbuka dan pengguna menekan menu hamburger, sidebar informasi menutup dan menu navigasi utama langsung tampil).
13. Redesain panel Informasi aplikasi OpenSID dari sidebar geser (Control Sidebar) menjadi dialog Modal Popup modern berbasis sistem navigasi multi-tab (Pembaruan & Rilis, Tentang Aplikasi, Catatan Rilis, Hak Akses & Tahapan, Komunitas & Donasi) yang responsif dan elegan.
14. Perbaikan tata letak profil wilayah desa pada sidebar admin (user-panel): penyesuaian ukuran logo daerah menjadi lebih proporsional (52px) dengan bayangan lembut tanpa terpotong lingkaran paksa, serta penataan teks nama desa, kecamatan, dan kabupaten yang sejajar rapi secara vertikal.
15. Fitur pembaruan otomatis aplikasi langsung dari repositori GitHub balongbesuk/OpenSIDOCR (Pure PHP & ZipArchive) khusus Administrator dengan proteksi berkas konfigurasi & database folder `desa/`.

#### Perbaikan BUG

1. Perbaikan query error duplicate entry `id_pend_config` pada tabel `log_penduduk` saat ubah data penduduk yang memiliki riwayat peristiwa kedatangan kembali.
2. Perbaikan penyimpanan anggota keluarga baru pada impor KK PDF dengan fallback ID jika tabel `tweb_penduduk` tidak memiliki autoincrement.
3. Perbaikan pembuatan dan penyimpanan surat RTF desa baru (penyesuaian tipe RTF Desa, filter kolom tabel, dan pengecekan ketersediaan berkas raw).
4. Perbaikan kompatibilitas RapidOCR engine dengan paket versi baru (`rapidocr` v1.4+ / `RapidOCROutput` object) untuk mencegah error `RapidOCROutput object is not subscriptable`.
5. Perbaikan akurasi parser OCR Kartu Keluarga: perbaikan batasan kata pada deteksi pendidikan (mencegah false positive SLTA akibat nama berawalan MA atau kata TAMAT) serta pekerjaan (mencegah MENGURUS RUMAH TANGGA salah terdeteksi sebagai GURU, dan penambahan pengenal BURUH HARIAN LEPAS serta profesi lainnya).
6. Perbaikan tata letak grup tombol tipe grafik (batang, lingkaran, garis) dan tombol cetak pada tema website desa agar tersusun sejajar rapi tanpa membungkus (wrapping) ke baris baru, serta preservasi parameter filter wilayah saat beralih jenis grafik.
7. Perbaikan integrasi menu sidebar statistik pada tema website desa (navigasi sticky di desktop, penyorotan menu aktif yang presisi, dan kelengkapan daftar statistik lainnya).
8. Perbaikan alur navigasi verifikasi kontak OTP Telegram dan Email pada Layanan Mandiri agar langsung diarahkan ke langkah selanjutnya tanpa perulangan langkah atau refresh yang membingungkan warga.
9. Perbaikan popup notifikasi dan pesan peringatan di Layanan Mandiri agar tidak terpotong atau tersembunyi pada tampilan layar perangkat mobile/smartphone.
10. Perbaikan tata letak sidebar Layanan Mandiri: memindahkan menu Dokumen ke bawah Cetak Salinan KK, serta mengeliminasi gaya garis bawah (text underline) global agar tampilan antarmuka lebih rapi dan bersih.
11. Perbaikan pembungkusan teks (word wrapping) judul surat dan posisi badge status pada kartu permohonan surat terkini di layar perangkat mobile agar teks tidak terpotong atau menyempit vertikal.
12. Perbaikan tombol aksi Ganti PIN dan elemen kartu aksi pada layar mobile agar tidak terpotong (clipped) atau meluap dari batas kontainer.
13. Perbaikan pemetaan placeholder status kawin dan pendidikan pasangan pada surat RTF Keterangan Nikah (`template-surat/surat_ket_nikah`).
14. Penanganan token CSRF dan status indikator pengiriman pada tombol kirim permohonan surat Layanan Mandiri serta perbaikan validasi elemen penandatangan pamong.
15. Perbaikan icon favicon website desa, panel admin, dan layanan mandiri agar menampilkan logo resmi desa Balongbesuk serta penambahan tag multi-ukuran (PNG 32x32, 16x16, apple-touch-icon) dan cache-busting.
16. Perbaikan penanganan blokir login admin (/siteman) agar status pemblokiran (lockout) tetap persisten dan hitung mundur tetap berjalan saat halaman di-refresh setelah salah kata sandi 3 kali.
17. Perbaikan pencegahan duplikasi nomor dan arsip surat ganda pada pencetakan surat (RTF/PDF): penambahan proteksi anti-double submit pada tombol cetak, umpan balik proses unduh, serta validasi backend cerdas agar tidak menaikkan nomor surat dan tidak membuat arsip duplikat saat terjadi pengunduhan ulang untuk pemohon yang sama pada hari yang sama.
18. Perbaikan inisialisasi skrip pemeriksa pembaruan GitHub pada modal informasi admin: pemindahan ke `@push('scripts')`, penundaan eksekusi aman (*deferred initializer*) menunggu `jQuery` dan DOM siap, serta penyegaran status tampilan awal untuk mencegah indikator berputar (*spinner*) tanpa henti (*stuck* memeriksa).
19. Perbaikan otorisasi controller pembaruan aplikasi (`Pembaruan_aplikasi`): beralih ke `MY_Controller` dan penanganan respons JSON 403 khusus administrator agar tidak terkena pengalihan (*redirect*) modul tidak terdaftar.
20. Sinkronisasi repositori dan rilis resmi ke `balongbesuk/OpenSIDOCR` pada konfigurasi aplikasi serta penambahan *fallback stream context* untuk cURL.
21. Perbaikan *false positive* badge notifikasi "Update" pada menu dropdown admin dan navbar: penanganan validasi cache rilis repositori agar tidak membaca cache usang OpenSID bawaan (`v2607.0.1`), sinkronisasi status keterbaruan antarmuka secara dinamis dengan status rilis `balongbesuk/OpenSIDOCR`, serta pembersihan berkas cache `desa/cache/version.json`.
22. Optimalisasi UI/UX antarmuka modal Informasi & Tentang OpenSIDOCR pada layar mobile/smartphone: layout flexbox tinggi penuh (*full-height app dialog*) mencegah pemotongan modal header, navigasi tab horizontal *pill carousel* (1 baris *smooth scrollable* tanpa *wrapping* bertumpuk 3 baris), resolusi tumpang tindih ikon hati pada kartu donasi, serta auto-scroll reset ke atas saat beralih tab.
23. Mitigasi celah keamanan CSV / Excel Formula Injection (OWASP / CWE-1236, isu OpenSID #12076): implementasi helper global `escape_formula()` dan sanitasi otomatis seluruh output ekspor spreadsheet/XLS (`Keluarga`, `Penduduk`, `Rumah Tangga/RTM`, `DPT`, `Log Penduduk`, `Wilayah`) serta ekspor CSV `Ekspor_model` untuk mencegah eksekusi formula saat berkas dibuka di Microsoft Excel atau LibreOffice Calc.
24. Perbaikan spam notifikasi "Data gagal disimpan Fitur ini tidak aktif" pada halaman Rumah Tangga (`/rtm`): optimasi pemuatan formulir DTKS pada dialog konfirmasi berbasis *event-driven* (`shown.bs.modal`) serta proteksi kondisi `modul_aktif('dtks')` agar tidak mengirimkan panggilan latar belakang saat modul dinonaktifkan.
25. Perbaikan rute akses menu admin Calon Pemilih (`/dpt`): penghapusan rute konflik `$route['dpt'] = 'first/dpt'` pada konfigurasi rute web agar menu admin Kependudukan > Calon Pemilih membuka controller `Dpt` admin dengan benar tanpa teralihkan (*redirect*) ke halaman website publik.

#### Perubahan Teknis

1. Refaktor modul `KkScanOcrParser`: integrasi runner Python mandiri dengan multi-path site-packages (cPanel/Linux/Windows), pipeline fallback rotasi otomatis (90°, -90°, 180°), dan penanganan direct object mapping `boxes` & `txts`.
2. Penambahan controller `fmandiri/Beranda.php` dan view `fmandiri/beranda.php` terintegrasi dengan pemuatan data real-time pemohon, status identifikasi, dan relasi log surat.
3. Optimalisasi stylesheet dan penanganan konflik kelas utilitas Tailwind CSS dengan framework Bootstrap 3 pada layout utama `fmandiri/template.php` menggunakan helper class `.hide-on-mobile`.
4. Optimasi & perbaikan modul Scan OCR Kartu Keluarga (`KkScanOcrParser`):
    - Penanganan `std::bad_alloc` (Out of Memory) pada shared hosting melalui auto-downscale gambar maksimal 1400px, pembatasan single-thread ONNX/BLAS, dan inisialisasi low-memory mode.
    - Resolusi dependensi otomatis untuk `onnxruntime` dan `rapidocr[onnxruntime]`.
    - Integrasi diagnostik server hosting real-time (PHP `exec()`, deteksi Python 3 & versinya, status modul ONNX, RapidOCR, dan OpenCV).
    - Penambahan fitur Reinstall / Perbaiki Dependensi (1-Click) dan Uninstall Engine langsung dari modal dialog Impor Scan KK.