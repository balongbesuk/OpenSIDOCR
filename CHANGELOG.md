# Changelog

## 2026-11-21

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

