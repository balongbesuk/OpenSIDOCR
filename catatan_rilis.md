Aplikasi **OpenSIDOCR** merupakan pengembangan lanjutan dari **OpenSID versi 2403.0.0** dan seterusnya oleh Pemerintah Desa Balongbesuk ([balongbesuk/OpenSIDOCR](https://github.com/balongbesuk/OpenSIDOCR)). Rilis ini memuat fitur kecerdasan buatan (AI RapidOCR) Kartu Keluarga, reaktivasi & pembenahan surat RTF, pembaruan otomatis dari repositori GitHub, serta modernisasi UI Layanan Mandiri dan Panel Admin.

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

#### Perubahan Teknis

1. Refaktor modul `KkScanOcrParser`: integrasi runner Python mandiri dengan multi-path site-packages (cPanel/Linux/Windows), pipeline fallback rotasi otomatis (90°, -90°, 180°), dan penanganan direct object mapping `boxes` & `txts`.
2. Penambahan controller `fmandiri/Beranda.php` dan view `fmandiri/beranda.php` terintegrasi dengan pemuatan data real-time pemohon, status identifikasi, dan relasi log surat.
3. Optimalisasi stylesheet dan penanganan konflik kelas utilitas Tailwind CSS dengan framework Bootstrap 3 pada layout utama `fmandiri/template.php` menggunakan helper class `.hide-on-mobile`.
4. Optimasi & perbaikan modul Scan OCR Kartu Keluarga (`KkScanOcrParser`):
    - Penanganan `std::bad_alloc` (Out of Memory) pada shared hosting melalui auto-downscale gambar maksimal 1400px, pembatasan single-thread ONNX/BLAS, dan inisialisasi low-memory mode.
    - Resolusi dependensi otomatis untuk `onnxruntime` dan `rapidocr[onnxruntime]`.
    - Integrasi diagnostik server hosting real-time (PHP `exec()`, deteksi Python 3 & versinya, status modul ONNX, RapidOCR, dan OpenCV).
    - Penambahan fitur Reinstall / Perbaiki Dependensi (1-Click) dan Uninstall Engine langsung dari modal dialog Impor Scan KK.