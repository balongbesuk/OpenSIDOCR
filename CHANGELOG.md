# Changelog

## 2026-11-21

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

