# Changelog

## 2026-11-24

### Salinan Kartu Keluarga (`kartu_keluarga.php`)
- Mengubah label dan ikon tombol menuju `keluarga/anggota` di halaman Salinan Kartu Keluarga (`donjo-app/views/sid/kependudukan/kartu_keluarga.php`) menjadi **Edit / Update Data Keluarga** (`bg-orange`, `fa-edit`) agar lebih sesuai dengan fungsinya.

### Penyelarasan `design.md` Admin (Header, Modal Informasi, & `/pengguna`)
- Dropdown Profil Header (`resources/views/admin/layouts/partials/header.blade.php`): tombol **Profil** & **Keluar** disamakan dengan Flexbox 50%-50% (`gap: 8px`, tanpa float & pseudo-element `::before`/`::after`), tinggi `38px` (mobile) / `34px` (desktop), dan `border-radius: 4px`.
- Modal Informasi & Tentang OpenSIDOCR (`resources/views/admin/layouts/partials/control_sidebar.blade.php`): menumpuk tombol aksi (`.info-action-group`) lebar penuh `38px` di mobile dan `34px` di desktop, membungkus tab navigasi (`flex-wrap: wrap`) agar tidak terpotong di HP, serta menghilangkan overflow horizontal `.modal-body`.
- Halaman `/pengguna` (`resources/views/admin/pengguna/index.blade.php`, `tab-profil.blade.php`, `tab-sandi.blade.php`): merapikan posisi foto profil & tombol verifikasi, menyeragamkan tinggi input/tombol (`34px` desktop / `38px` mobile), mengubah `.box-footer` menjadi Flexbox (`margin-left: auto`), menghapus `btn-flat` & konflik class pada toggle **Notifikasi Telegram**, memperbaiki `for`/`id`, dan menambahkan `cursor: pointer` pada ikon lihat sandi.

### Impor KK PDF / Scan OCR (`Keluarga.php`)
- Menambahkan deteksi & kotak peringatan **Pengurangan Anggota Keluarga** pada pratinjau Impor KK (`ajax_import_pdf_preview.php`, `import_pdf_preview.php`, dan partial `_import_removed_members.php`) apabila ada penduduk aktif (`status_dasar = 1`) di KK database yang tidak lagi tercantum pada KK terbaru yang diunggah, lengkap dengan tautan **Cek Penduduk** per anggota.

## 2026-11-21

### Artikel Headline & Ticker Beranda (`desa/themes/tema`)
- Memperbaiki gambar artikel yang disematkan (`$headline`) agar tampil di mobile (`w-full h-64 sm:h-80 lg:h-auto`) dan menambahkan badge `Disematkan` di `partials/content.php`.
- Memperbaiki tombol Pause/Play pengumuman berjalan (`#tickerToggle`) menggunakan class `.is-paused` (`animation-play-state: paused !important`) di `partials/slider.php`.

### Perbaikan Path Konfigurasi Tema (`desa/themes/tema`)
- Memperbaiki pembacaan `config_desa.php` dan `commons/disqus.php` dengan mengganti `FCPATH . $folder_themes` menjadi `dirname(__DIR__)` di `commons/disqus.php`, `commons/meta.php`, `layouts/artikel.tpl.php`, `layouts/halaman_statis.tpl.php`, dan `partials/kelompok.php` (karena `$folder_themes` OpenSID bernilai relatif `../../desa/themes/tema`), serta menormalisasi `HTTP_HOST` (case-insensitive & tanpa port) untuk pengecekan `onesignal_host`.

### Layanan Mandiri (`/layanan-mandiri/beranda`) & Polish Tema (`desa/themes/tema`)
- Layanan Mandiri (`donjo-app/views/fmandiri/beranda.php`, `template.php`): mendinamiskan 3 hardcode `"Balongbesuk"`, menghapus pembatasan zoom `user-scalable=no`, menambahkan SRI (SHA-384) pada Font Awesome `6.5.1` & SmartWizard `5`, meningkatkan kontras teks (`text-slate-500`/`300`), menambahkan `width`/`height` foto profil, menaikkan tap target tombol aksi ke `>=44px`, dan menambahkan `aria-label` pada tombol FAB `+`.
- Polish Tema (`desa/themes/tema`): mengganti gradient teks menjadi warna solid & menghapus titik di akhir judul (`partials/slider.php`, `commons/profildesa.php`), menghapus orb blur dekoratif (`commons/profildesa.php`, `commons/copyleft.php`), serta menenangkan animasi hover (`commons/profildesa.php`, `partials/content.php`).

### Komentar Bawaan & Portabilitas Tema (`desa/themes/tema`)
- Multi-desa: memisahkan konfigurasi `disqus_shortname`, `onesignal_app_id`, dan `onesignal_host` ke `config_desa.php` (gitignored) dengan template `config_desa.example.php`, serta mendinamiskan `apple-mobile-web-app-title` (`commons/meta.php`) dan filter link internal artikel (`layouts/artikel.tpl.php`).
- Fallback Komentar OpenSID: menambahkan `commons/komentar_artikel.php` (daftar komentar, flashdata `notif`, form `first/add_comment/{id}`, reload captcha, validasi No. HP angka saja, serta pesan validasi bahasa Indonesia) ketika Disqus nonaktif (`artikel.tpl.php`, `halaman_statis.tpl.php`), serta menyembunyikan blok Disqus kosong di `partials/kelompok.php`.
- Keamanan Komentar (`donjo-app/controllers/First.php`): memvalidasi artikel aktif & `boleh_komentar === 1` di `add_comment()`, membatasi panjang komentar `max_length[200]`, memvalidasi redirect `HTTP_REFERER` same-host, dan mencegah double-encoding / XSS output di `commons/komentar_artikel.php` & `widgets/komentar.php`.

### Aksesibilitas & Mobile Layout
- Beranda & Tema (`assets/css/app.css`, `partials/slider.php`, `commons/header.php`, `commons/copyleft.php`, `widgets/perkembangan_penduduk.php`): menambahkan `@media (prefers-reduced-motion: reduce)`, tombol Pause/Play ticker (`#tickerToggle`), tombol submit pencarian di mobile, target sentuh minimal `44x44px` (`w-11 h-11`), `focus-visible` ring, kontras subjudul hero, dimensi `width`/`height` gambar hero & footer, serta menghapus dot animasi dekoratif.
- Halaman Login (`donjo-app/views/siteman.php`, `donjo-app/views/fmandiri/masuk.php`): memperbaiki tabrakan bar "Ke Beranda" dengan logo di mobile (`pt-24 lg:pt-16`), meningkatkan kontras teks navigasi, menambahkan `width`/`height` logo, `peer-focus-visible` pada toggle sandi/PIN, dan `lg:overflow-hidden` agar form tetap bisa di-scroll di HP.

### Halaman Login (`/siteman` & `/layanan-mandiri/masuk`)
- Autofill & Aksesibilitas: menambahkan `for`/`id` pada `<label>` dan `<input>`, `required` native, `autocomplete="username"` (`spellcheck="false"`, `autocapitalize="none"`) & `autocomplete="current-password"` (tetap `off` pada mode anjungan), landmark `<main>`, `role="alert"` pada notifikasi/error, serta `:focus-visible` di `donjo-app/views/siteman.php` dan `donjo-app/views/fmandiri/masuk.php`.
- Security & Markup: menambahkan `integrity` (SHA-384), `crossorigin="anonymous"`, dan `referrerpolicy="no-referrer"` pada CDN Font Awesome `6.4.0` & SmartWizard `5`, serta menghapus tag `</style>` ganda di `fmandiri/masuk.php`.

### Console, Security Header, & Widget
- `Permissions-Policy`: menghapus 8 directive usang (`ambient-light-sensor`, `battery`, `document-domain`, `layout-animations`, `legacy-image-formats`, `oversized-images`, `unoptimized-images`, `unsized-media`) di `donjo-app/third_party/security/config/security/headers.php`.
- OneSignal SDK: membatasi inisialisasi agar hanya berjalan pada host produksi `balongbesuk.desa.id` (`desa/themes/tema/commons/meta.php`).
- Highcharts & PWA SW: memuat `highcharts-more.js` dan `accessibility.js` di dalam `hcScript.onload` (`desa/themes/tema/widgets/perkembangan_penduduk.php`), serta membatasi `StaleWhileRevalidate` pada `pwabuilder-sw.js` hanya untuk request same-origin.

### Tema Publik (`desa/themes/tema`)
- Security: menambahkan `integrity` (SHA-384), `crossorigin="anonymous"`, dan `referrerpolicy="no-referrer"` pada aset CDN OwlCarousel2 & Leaflet di `partials/lapak/index.php` dan `partials/pembangunan/detail.php`.
- Accessibility: mengubah `<main id="hero">` menjadi `<section id="hero" aria-label="Sorotan Utama">` di `template.php` agar hanya ada satu `<main>` per halaman.
- Modern Web Standards: mengganti `modalContent.innerHTML = ''` dengan `modalContent.replaceChildren()` (`layouts/peta_statis.tpl.php`), menambahkan `scrollbar-width` & `scrollbar-color` standar dengan fallback `@supports not (scrollbar-color: auto)` (`partials/statistik/sidenav.php`), serta menyinkronkan `<meta name="color-scheme">` saat inisialisasi & toggle tema (`commons/meta.php`, `assets/js/app.js`).

## 2026-11-17

### Hari Libur Kehadiran (`/kehadiran_hari_libur`)
- Fix: import hari libur error `date_format(): Argument #1 must be DateTimeInterface, bool given` (Kehadiran_hari_libur.php).
- Import hari libur nasional & cuti bersama (SKB 3 Menteri) cukup 1 klik per tahun.
- Filter tahun di tabel, default tahun berjalan.
- Tampilan kalender bulanan (tab Kalender/Tabel), sinkron dengan libur nasional (merah) dan cuti bersama (amber).
- Perbaikan tampilan desktop & mobile sesuai design.md; fix teks ringkasan bulan tidak terbaca (callout-info).

### Penyelarasan design.md
- `/bumindes_arsip`: fix typo class `col-lg-$`, kartu navigasi 2 kolom di HP; hapus `btn-flat` & `&nbsp;`, tombol aksi dibungkus `.btn-group-aksi`, `class="aksi"` salah di kolom teks dihapus, filter tahun memakai select2.
- `/pengaduan_admin`: header ganda disatukan (tombol hapus + filter status), form mencakup header, tombol aksi `.btn-group-aksi`, klik kartu status langsung memfilter tabel.
- `/lapak_admin/pelapak`: `<a>` dipindah ke dalam kolom grid navigasi, hapus `btn-flat`, tombol aksi `.btn-group-aksi`, filter status reload via `change`.
- Buku administrasi (inventaris, lembaran desa, ekspedisi): tombol pintas tambah data + petunjuk.
- Navigasi jabatan: hapus CSS mini-submenu yang tidak terpakai.

### Hak Akses
- Modul Pengaturan (setting, modul, man_user, grup, database, info_sistem, sinkronisasi, optimasi_gambar) hanya untuk Administrator.
- Hapus logo/path identitas desa hanya oleh Administrator.
- Null-safety submodul pada form & model grup (PHP 8).

