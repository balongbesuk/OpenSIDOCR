# DESIGN.md: Agrile & OpenSID Design System Specification

Dokumen ini memuat standar desain resmi:
1. **Bagian 1:** Tema Publik Frontend (Agrile – Farm & Farmer)
2. **Bagian 2:** Standar UI & Ergonomi Responsif Admin OpenSID (Backend / SID)

---

# BAGIAN 1: Agrile – Farm & Farmer WordPress Theme Design System
## Implementasi Resmi Desain Agrile (ThemeForest #55480845 by Themelexus)

> **Live Inspection Reference:**  
> **Agrile Demo:** `https://demo2.themelexus.com/agrile/`  
> *Preview Item:* `https://preview.themeforest.net/item/agrile-farm-farmer-wordpress-theme/full_screen_preview/55480845`  
> *Author:* Themelexus (Power Elite Author)

### 1. Fondasi Visual & Desain Autentik Agrile

#### A. Tipografi Resmi
- **Primary / Display Font:** **`Syne`** (`font-family: 'Syne', sans-serif`, weight `700` & `800`).
  - Digunakan pada: Logo brand, Menu navigasi utama, Judul Hero (H1), Judul Section (H2), Kartu Layanan (H3/H4), Angka proses `01/02/03`, dan Tombol aksi.
- **Body & Secondary Font:** **`Rethink Sans`** (`font-family: 'Rethink Sans', sans-serif`, weight `400`, `500`, `600`).
  - Digunakan pada: Paragraf pengantar, cuplikan berita, teks deskripsi layanan, dan footer.
- **Fallback:** `system-ui, -apple-system, sans-serif`.

#### B. Palet Warna Autentik (Computed CSS Variables)
```css
:root {
  /* Warna Utama Agrile (Computed dari --e-global-color-*) */
  --agrile-primary: #107634;        /* Kelly Emerald Green khas Agrile */
  --agrile-secondary: #051815;      /* Deep Pine / Blackish Forest Green */
  --agrile-accent: #051815;         /* Aksen Gelap */
  --agrile-highlight: #EECD15;      /* Sun Yellow / Panen Emas Terang */
  --agrile-text: #585C59;           /* Teks Body (Soft Graphite Gray) */
  --agrile-lighter: #A7A9A7;        /* Teks Redup / Meta */
  
  /* Latar Belakang & Pembatas */
  --agrile-bg: #FAF9F7;             /* Kanvas Bersih Krem-Putih Alami Agrile */
  --agrile-card: #FFFFFF;           /* Kartu Putih Murni */
  --agrile-field: #F4F5F3;          /* Latar Input & Pod Sekunder */
  --agrile-border: #E8EAE5;         /* Garis Batas Halus */
  
  /* Mode Gelap Terpadu */
  --agrile-dark-bg: #051815;
  --agrile-dark-card: #0c2621;
  --agrile-dark-border: rgba(16, 118, 52, 0.3);
}
```

### 2. Struktur Tata Letak Halaman Utama (Agrile Home 1 Architecture)
1. **Transparent Header Absolute (`header-absolute`):** Navigasi mengambang transparan di atas hero, berlatar blur saat discroll dengan tombol pill "Layanan Mandiri".
2. **Centered Grand Photographic Hero + Curved Arch Divider:** Headline H1 Syne bold, CTA ganda, dan kurva lengkung bawah SVG khas Agrile.
3. **Section About Agrile:** Tata letak dua kolom asimetris profil desa pertanian.
4. **Section Services (Our Service):** Kartu thumbnail lengkung dengan ikon pod agraris.
5. **Section Process (Work Process):** 4 langkah pelayanan bernomor raksasa `01` - `04`.
6. **Transparansi APBDes & Proyek:** Showcase realisasi dana & infrastruktur tani.
7. **Warta Terkini (Our Blogs):** Grid 3 kartu berita berbingkai `rounded-2xl` dengan badge tanggal uppercase.
8. **Pamong Desa:** Kartu portrait aparatur desa dengan nama pejabat font `Syne`.
9. **Rich Footer:** Palet pine gelap `#051815` dengan 4 kolom navigasi & legalitas.

---

# BAGIAN 2: Standar UI & Responsivitas Admin OpenSID (Backend / SID)
## Aturan Desain Standar Mobile & Desktop (Anti-Slop & Ponytail Ergonomics)

Standar ini wajib diterapkan secara konsisten pada seluruh modul admin OpenSID (`/penduduk`, `/keluarga`, `/status_desa`, `/identitas_desa`, dll.) untuk menjamin kemudahan penggunaan, konsistensi visual, dan pencegahan bug antarmuka.

```
┌────────────────────────────────────────────────────────────────────────┐
│ FILOSOFI: MINIMAL EFFECTIVE CHANGE, ERGONOMIS & ZERO OVERFLOW         │
│ 1. Mobile First: Target sentuh aman (≥ 38px), spasi lega, no scroll X. │
│ 2. Desktop Elegance: Flexbox sejajar, tinggi seragam 34px, no floats. │
│ 3. Clean Hierarchy: List bersih garis pembatas tipis, no border samar.│
└────────────────────────────────────────────────────────────────────────┘
```

---

### 1. Standar Modul Tabel & Daftar Data (Aksi Baris Tabel)
*Contoh modul rujukan: `/penduduk`, `/keluarga`*

#### A. Dropdown Menu (Box-Header & Baris Tabel)
- **Hilangkan Border Samar & Garis Pemotong Ikon:** Bersihkan seluruh border kotak samar bawaan `.btn` dan garis pemisah vertikal (`border-right`) pada ikon `.btn-social` di dalam dropdown. Ikon diset `position: static !important; width: 18px !important; margin-right: 10px !important;` agar teks menu tidak tertimpa ikon.
- **Garis Pembatas Horizontal:** Gantilah dengan pembatas tipis horizontal (`border-bottom: 1px solid #f1f5f9;`) di setiap baris item menu. Item terakhir tanpa border.
- **Tinggi, Padding & Tipografi:**
  - Desktop: Tinggi minimal `34px`, padding `8px 14px`, ukuran font `13px`, font-weight `500`, `min-width: 200px !important;`, teks rata kiri `white-space: nowrap !important;`.
  - Mobile: Tinggi minimal `38px` (finger-friendly), font `13px`.
- **Aksi Kritis / Destruktif:** Item aksi hapus/batal (misal `[data-target="#confirm-delete"]`, `.hapus-terpilih`) wajib diberi penegasan teks merah (`color: #dc2626 !important; font-weight: 600;`) dengan hover latar merah lembut (`#fef2f2`).
- **Efek Hover:** Latar belakang abu-abu terang halus (`#f8fafc`) dengan teks gelap kontras (`#0f172a`).

#### B. Header & Pagination Tabel di Layar Kecil (Mobile)
- Tombol aksi massal (`+ Tambah`, `Cetak`, `Unduh`) mengalir vertikal / flex wrap berjarak `6px`.
- **Dropdown Menu Interaktif & Anti-Block:**
  - Sembunyikan `.dropdown-backdrop { display: none !important; }` bawaan Bootstrap 3 yang sering menghalangi event sentuh (*touch*) pada perangkat mobile.
  - Dropdown menu yang terbuka wajib berstatus `position: relative !important; z-index: 1001 !important;` dengan item sentuh minimal `38px` agar setiap pilihan (Cetak, Unduh, Pencarian, dll.) dapat langsung diklik tanpa terblokir.
- Input pencarian dan filter dropdown mengambil lebar penuh 100% dengan margin bawah teratur.
- Pagination tabel bergeser ke tengah (*center*) dengan padding sentuh minimal `36px`.

#### C. Standarisasi Modul Berbasis DataTables JS (/stunting, /pengaduan, dll.)
- **Kontrol 'Tampilkan Entri' (.dataTables_length):**
  - Pada mobile, teks dan dropdown wajib tetap satu baris horizontal (display: inline-flex; align-items: center; gap: 6px;).
  - Dropdown entri memiliki lebar otomatis (width: auto; min-width: 65px; height: 32px;), dilarang dipaksa width: 100% agar tidak terpecah menjadi 3 baris terpisah.
- **Kontrol Pencarian (.dataTables_filter):**
  - Kotak pencarian berada di tengah (*center*) dengan display: inline-flex; width: 100%; max-width: 300px; sehingga label dan input berada sejajar.
- **Pencegahan Teks Tertabrak Ikon Sortir (`th.sorting`):**
  - Setiap kolom header yang dapat disortir wajib memiliki padding-right: 28px !important; dan white-space: nowrap !important; agar teks header (misal NAMA POSYANDU, NOMOR KIA) tidak terpotong atau tertabrak oleh ikon panah sortir (⇅).
- **Padding Kontainer Tabel (.table-responsive > .dataTables_wrapper):**
  - Diberi padding 12px 10px 6px 10px agar elemen kontrol tidak menempel rapat pada garis batas terluar kontainer kartu.
- **Perataan Kolom Aksi (`th.aksi` & `td.aksi`):**
  - Kolom aksi wajib rata kiri (`text-align: left !important;`) agar deretan tombol aksi (Ubah, Kunci/Buka, Favorit, Hapus) tetap sejajar rapi vertikal per kolom dan tidak bergeser (*zig-zag*) saat jumlah tombol bervariasi antar baris (misal pada /surat_master).

---

### 2. Standar Tombol Aksi (Box-Header & Box-Footer)
*Contoh modul rujukan: `/identitas_desa` (Box-Header), Form Penduduk, Peta Kantor, Peta Wilayah Desa/Dusun/RW/RT (Box-Footer)*

#### A. Tampilan Desktop / Layar Lebar (`min-width: 768px`)
- **Standarisasi Dimensi Seragam (Header & Footer):**
  - Tinggi tombol & select filter: seragam `34px` (`min-height: 34px !important; height: 34px !important; line-height: 34px !important`).
  - Sudut: `border-radius: 4px !important`.
  - Spasi antar elemen: `margin-right: 6px !important; margin-bottom: 4px !important`.
  - Padding: `padding: 0 12px 0 36px !important` (untuk `.btn-social`), `padding: 0 12px !important` (tombol standar), atau `padding: 0 10px !important` (select).
  - Bayangan: `box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08) !important`.
  - Tipografi: `font-size: 13px !important; font-weight: 500 !important; color: #334155 !important`.
  - Ikon `.btn-social`: Lebar tetap `30px`, tinggi 100%, posisi absolut rata tengah, garis pemisah halus di sebelah kanan (`border-right: 1px solid rgba(0, 0, 0, 0.15)`).

- **Dropdown / Filter di dalam Box-Header:**
  - Dropdown filter (misal pilihan tahun pada `/bumindes_inventaris_kekayaan`, `/bumindes_hasil_pembangunan`, `/bumindes_rencana_kerja`, dll.) memiliki lebar fleksibel proporsional (`min-width: 140px; width: auto; max-width: 240px;`) sejajar langsung dengan deretan tombol aksi.
  - Pada elemen berbasis Select2, wadah terluar (`.select2-container`) wajib bebas dari border ganda dan padding (`border: none !important; padding: 0 !important; background: transparent !important;`), sedangkan border tunggal dan tinggi `34px` diterapkan secara presisi pada `.select2-selection--single` untuk mencegah efek kotak ganda (*double box*).
  - Dilarang membungkus filter dan tombol dengan grid kolom persentase kaku (`col-sm-2` dan `col-sm-10`) di dalam header karena menyebabkan tabrakan batas elemen dan teks terhimpit.
  - Pisahkan kontainer: `.box-header` khusus untuk toolbar/aksi, sedangkan tabel data dan kontrolnya wajib dibungkus di dalam `.box-body`.

- **Tombol Addon pada Input-Group (`.input-group .btn`):**
  - Tombol addon input (seperti tombol Browse/Cari pada `.input-group-btn`) dikecualikan dari aturan tombol kartu penuh (`width: 100%`) baik di desktop maupun mobile.
  - Input teks dan tombol addon tetap menyatu 1 baris sebagai satu kesatuan (*cohesive input unit*):
    - Input file/teks: `display: table-cell; width: 100%; border-radius: 4px 0 0 4px; height: 38px (mobile) / 34px (PC);`.
    - Tombol Browse: `display: inline-flex; width: auto; border-radius: 0 4px 4px 0; height: 38px (mobile) / 34px (PC);`.
  - Mencegah efek tangga patah (*stepped staircase*) pada formulir berkas (contoh: `/keuangan/impor_data`).

- **Modern Flexbox Sejajar pada Box-Footer:**
  ```css
  .box-footer {
      display: flex !important;
      align-items: center !important;
      justify-content: flex-start !important;
      flex-wrap: wrap !important;
      gap: 6px !important;
      padding: 10px 15px !important;
  }
  ```
- **Hapus Float Legacy:** Seluruh elemen tombol, label, dan div input warna wajib `float: none !important`.
- **Urutan Alami Elemen:**
  $$\text{[Kembali]} \to \text{[Aksi Tambahan / Kosongkan]} \to \text{[Export]} \to \text{[Reset]} \to \text{Input Field (Warna)} \to \text{[Simpan]}$$
- **Tombol Simpan di Kanan:** Dorong tombol aksi utama/simpan pada formulir ke ujung kanan menggunakan `margin-left: auto !important`.

#### B. Tampilan Mobile (`max-width: 767px` - Opsi A: Kartu Berjarak Aman)
- Setiap tombol ditampilkan sebagai kartu vertikal independen dengan lebar 100% atau grid 2 kolom.
- Tinggi sentuh nyaman: `38px` (`min-height: 38px !important; height: 38px !important; line-height: 38px !important`).
- Jarak antar tombol: `margin-bottom: 8px !important; border-radius: 4px !important;`.
- Ikon `.btn-social`: Lebar tetap `36px`, tinggi 100%, line-height `38px`.
- Tombol aksi modul (seperti Cetak, Unduh, Bersihkan pada `/cdesa`) wajib ditempatkan di dalam `.box-header with-border` agar tidak bertumpuk rapat tanpa jarak (menempel kaku) akibat class bawaan `.btn-flat visible-xs-block`.
- Kotak pencarian pada `.box-body` mobile diberi jarak napas `margin-bottom: 10px !important;` terhadap tabel di bawahnya.
- Tombol Simpan diletakkan paling bawah dengan warna kontras (biru info/hijau sukses) sebagai jangkar penyelesaian form.

---

### 3. Standar Modul Peta Wilayah & GIS Leaflet
*Contoh modul rujukan: `/identitas_desa/maps/kantor`, `/identitas_desa/maps/wilayah`*

#### A. Penanganan Input Koordinat & Warna
- Input Latitude, Longitude, dan Warna wajib berukuran proporsional:
  - Desktop: tinggi `34px`.
  - Mobile: tinggi `38px` dengan addon colorbox `48px` lebar.
- Addon pemilih warna menampilkan kotak warna preview di sebelah kanan input dengan sudut membulat rapi.

#### B. Aturan Sinkronisasi Warna Poligon Peta (`assets/js/peta.js`)
- **Penerapan ke Leaflet:** Fungsi `showCurrentPolygon` dan `showCurrentMultiPolygon` wajib melewatkan opsi `color` (garis tepi) dan `fillColor` (arsiran) sesuai nilai `warna` dari database:
  ```javascript
  var poly_options = {
      showMeasurements: true,
      measurementOptions: { showSegmentLength: false },
      color: warna || "#3388ff",
      fillColor: warna || "#3388ff"
  };
  ```
- **Live Real-time Preview:** Wajib menyertakan event listener ke plugin colorpicker dan input warna:
  ```javascript
  var updateWarna = function(c) {
      if (c) polygon.setStyle({ color: c, fillColor: c });
  };
  $(".my-colorpicker2").on("changeColor", function(e) {
      updateWarna(e.color ? e.color.toString() : $("#warna").val());
  });
  $("#warna").on("input change", function() {
      updateWarna($(this).val());
  });
  ```
- Saat pengguna memilih warna di palet atau mengetik hex/rgba, poligon di peta langsung berubah warnanya seketika sebelum tombol Simpan ditekan.

---

### 4. Standar Modul Status Desa (IDM & SDGs)
*Contoh modul rujukan: `/status_desa`*

#### A. Navigasi Tab (IDM & SDGs)
- Di mobile, navigasi menggunakan 2 kolom berdampingan (`col-xs-6`).
- Tinggi kotak navigasi dikompres menjadi `56px` (ikon `52px`, font ukuran `15px` bold).

#### B. Ringkasan Skor IDM (4 Kartu Status)
- Menggunakan grid simetris 2x2 di mobile (`col-xs-6`).
- Jarak aman antar kartu: `margin-bottom: 10px !important`.
- Tipografi: Angka skor `19px` - `20px` tebal, status kategori (misal: "MANDIRI") `15px` extra-bold terpusat.

#### C. Galeri Indikator SDGs (Opsi A - Grid 2 Kolom)
- **Rasio Logo 1:1:** Logo indikator SDGs wajib mempertahankan rasio aspek persegi murni (`aspect-ratio: 1 / 1; width: 64px; height: 64px; object-fit: contain;`) agar tidak terdistorsi atau lonjong.
- **Kartu Kompak:** Tinggi kartu dibatasi maksimal `72px` di mobile dengan skor tebal `18px`.
- Menghemat ruang gulir hingga 60% dibanding tata letak satu kolom lama.

---

### 5. Standar Tabel Laporan Formal & Statistik (`/laporan`, `/laporan_rentan` - Lampiran A-9)
- **Header Multi-Level:** Wajib menggunakan `vertical-align: middle !important;` pada sel bertingkat (`rowspan`/`colspan`) agar teks judul tidak jatuh ke dasar sel secara canggung. Baris grup utama (`th[colspan]`) diberi aksen warna `#e2e8f0` untuk membedakan kategori makro dan sub-kolomnya.
- **Kisi & Batas Sel:** Menggunakan batas kisi formal `#cbd5e1` dengan background header `#f1f5f9` dan teks kontras `#1e293b`. Baris penomoran kolom statistik (`1, 2..12`) diberi font italic 11px berlatar `#f8fafc`.
- **Tautan Rincian Data (Drill-down):** Sel angka berstatus tautan (`td.bilangan a`, `td a`) diberi penegasan warna `#0284c7`, font-weight 600, dan efek hover lembut `#e0f2fe` agar operator mudah mengenali angka yang dapat diklik untuk memeriksa rincian data penduduk.
- **Baris Total / Akumulasi Akhir:** Baris total di `tfoot` diberi penegasan khusus latar hijau lembut `#f0fdf4`, teks tebal kontras `#14532d`, dan garis batas atas tebal `#86efac` sebagai penanda total akhir kependudukan.

---

### 6. Checklist Verifikasi Sebelum Selesai (Quality Gate)
- [ ] **Zero Horizontal Scroll:** Tidak ada elemen yang meluap melebihi lebar layar pada viewport 360px–420px.
- [ ] **Contrast & Accessibility:** Kontras teks terhadap latar belakang minimal 4.5:1 (WCAG AA).
- [ ] **No Stray Floats:** Tidak ada `float: left` / `float: right` yang merusak grid atau menindih elemen lain di desktop.
- [ ] **CSS Braces Balance:** Jumlah kurung kurawal pembuka `{` dan penutup `}` di file CSS selalu seimbang (`diff = 0`).
- [ ] **Live Interaction Test:** Interaksi formulir, colorpicker, dan preview peta berfungsi reaktif tanpa error JavaScript pada console.


### Sub-E: Modul Pembangunan (`/admin_pembangunan/form`)
- **Struktur Radio Toggle Lokasi:** Menghapus kelas grid `.col-sm-6` yang disematkan langsung pada `.btn-group` dan `<label class="btn">`. Menghapus wrapper `.row` dan label kosong bersarang sehingga tombol *Pilih Lokasi* dan *Tulis Manual* tersusun rapi tanpa patahan flex/grid.
- **Input Durasi Waktu & Satuan:** Menggunakan kombinasi responsif `col-xs-7 col-sm-8` dan `col-xs-5 col-sm-4` dengan `style="width:100%"` pada Select2 agar durasi angka dan opsi satuan (Bulan/Tahun) tetap berdampingan dalam satu baris di layar ponsel tanpa bertumpuk sempit.
- **Kartu Gambar Utama (`col-md-3`):**
  - Mengganti tag usang `<center>` dengan utilitas `.text-center`.
  - Memberikan frame pratinjau foto `.img-thumbnail` dengan batasan tinggi `max-height: 200px` dan spasi bawah yang proporsional.
  - Memisahkan input hidden keluar dari `.input-group` dan menata tombol *Browse* secara terpadu.
  - Mengganti kotak addon merah sempit dengan checkbox hapus gambar yang jelas dan hanya tampil saat data gambar eksis.
- **Pembersihan Atribut & Null-Safety PHP:** Menghapus duplikasi atribut (`maxlength`, `name`, tag penutup `</input>`), serta memastikan seluruh pemanggilan properti `$main->...` menggunakan operator null-coalesce (`??`) agar aman saat tambah data baru.

- **Penyesuaian Tinggi Waktu & Satuan:** Menyamakan tinggi input text dan dropdown Select2 menjadi seragam (34px di desktop, 36px di mobile) dengan `border: 1px solid #cbd5e1`, menghapus selisih margin bawah pada Select2, dan merapatkan jarak antarkolom menjadi 10px (`padding: 0 5px`) agar input durasi dan satuan waktu sejajar sempurna.
- **Tombol Toggle Lokasi Sejajar Lebar Penuh:** Menggunakan `.btn-group.btn-group-justified` (`display: flex; width: 100%`) dengan kontras warna aktif (`#0284c7` teks putih) vs non-aktif (`#f1f5f9` teks `#0369a1`), sehingga kedua tombol membentang 50%-50% memenuhi lebar form sejajar dengan dropdown lokasi di bawahnya.

### Sub-F: Modul Lapak Admin Pelapak (`/lapak_admin/pelapak`)
- **Penyatuan Header Aksi & Filter:** Menghapus pembagian dua baris `.box-header` yang memicu garis pembatas ganda dan menghilangkan pembungkus kaku `col-sm-2`. Tombol *Tambah Data*, *Hapus Data Terpilih*, dan dropdown filter *Semua Status* kini berada dalam satu `.box-header with-border` yang sejajar di desktop dan tertata rapi sebagai card-pill di mobile.
- **Perbaikan URL Tambah Data & Tipografi:** Menghilangkan variabel tak terdefinisi `{$main->id}` pada tombol Tambah Data, menghapus kelas ganda (`btn-sm btn-sm` dan `fa fa fa-plus`), serta mengoreksi tipografi header tabel dari *No. Telelpon* menjadi *No. Telepon*.
- **Sinkronisasi Index Kolom Sorting DataTables:** Menyelaraskan indeks kolom pengurutan server-side (`ORDER_ABLE_PELAPAK`) pada `Lapak_model` dan `Lapak_admin` agar pengurutan kolom *Pelapak* (index 3) dan *No. Telepon* (index 4) bekerja akurat serta menonaktifkan klik pengurutan pada kolom hitungan *Jumlah Produk* (index 5) untuk mencegah galat 500.
- **Modal Form & Peta Lokasi Pelapak:** Menambahkan `style="width: 100%"` pada Select2 `#id_pend` di dalam modal agar tidak menyusut, mengamankan akses properti null saat tambah data, serta memperbaiki breadcrumb typo link `produdk/pelapak` menjadi `lapak_admin/pelapak` pada halaman peta lokasi.


### Sub-G: Modul Pengaturan Modul (`/modul`)
- **Restrukturisasi Header & Tombol Default Server:** Memindahkan judul *Pengaturan Modul* ke `.box-header with-border` yang standar. Tombol *Kembalikan ke default penggunaan server* kini menggunakan kelas responsif standar sehingga membentang penuh (100% width card-pill) di mobile dengan jarak margin bawah 12px, menghilangkan tombol sempit yang menempel pada input filter.
- **Pemisahan Jarak Filter Status & Kotak Pencarian:** Menghapus wrapper bersarang yang tidak perlu dan menambahkan margin vertikal 8px pada kolom filter *Semua Status* dan input *Cari...*, sehingga kedua kontrol tidak saling menempel rapat di layar ponsel.
- **Penyatuan Header Submodul:** Menghapus pembatas ganda pada tampilan submodul dengan menyatukan tombol *Kembali Ke Daftar Modul* dan label nama *Modul Utama* ke dalam satu `.box-header with-border`.
- **Form Ubah Modul:** Menstandarkan radio toggle button group *Status Modul* (Aktif / Tidak Aktif) menggunakan `.btn-group.btn-group-justified` yang proporsional 50%-50% dan menghapus tag penutup ilegal `</input>`.

- **Penataan Tombol Default Server sebagai Aksi Header:** Memindahkan tombol *Kembalikan ke default penggunaan server* langsung ke dalam `.box-header with-border` (posisi standar tombol aksi OpenSID). Tombol kini otomatis berwujud card-pill 38px dengan radius sudut 4px, lebar penuh 100%, dan terpisah oleh garis border header dari dropdown filter dan kotak pencarian.

### Sub-H: Penanganan Galat Tampilan Halaman Submodul (`/modul/sub_modul/{id}`)
- **Perbaikan Fatal Error PHP 8 pada `count($data['submodul'])`:**
  - Pada pemanggilan submodul (`/modul/sub_modul/{id}`), fungsi `Modul_model::list_sub_modul()` hanya mengambil daftar submodul sehingga key array `'submodul'` tidak didefinisikan. Pemanggilan fungsi bawaan `count($data['submodul'])` pada PHP 8 memicu `TypeError: Argument #1 ($value) must be of type Countable|array, null given` yang menghentikan render HTML di baris pertama tabel (`No 1`).
  - Mengubah pemeriksaan kondisi tombol *Lihat Sub Modul* pada `donjo-app/views/setting/modul/table.php` menjadi `!empty($data['submodul'])`.
  - Menginisialisasi `$data[$i]['submodul'] = []` pada `Modul_model::list_sub_modul()` untuk memastikan integritas struktur data array.
- **Keseimbangan Tag Penutup Div Layout AdminLTE:**
  - Memperbaiki tag penutup `</div>` pada `table.php` yang sebelumnya thiếu 1 tag penutup sehingga `<div class="content-wrapper">` tidak tertutup sempurna dan merusak tata letak footer AdminLTE.
- **Null-Safety Modul Induk & Judul Terpusat (Standar `/dpt`):**
  - Mengamankan pemanggilan label modul utama dengan null-coalescing `SebutanDesa($sub_modul['modul'] ?? '')` serta menambahkan auto-redirect ke `modul/clear` pada `Modul::index()` jika ID submodul dalam session tidak ditemukan di database.
  - Memposisikan judul modul utama tepat di bawah tombol *Kembali Ke Daftar Modul* dalam blok `<div class="box-header"><h4 class="text-center" style="margin-top: 5px; margin-bottom: 5px;"><strong>MODUL UTAMA : [NAMA MODUL]</strong></h4></div>` persis seperti standar judul terpusat pada halaman `/dpt` dan `/cdesa`, sehingga tidak membingungkan pengguna seperti tombol yang bisa diklik.

### Sub-I: Modul Pengaturan Database (`/database`)
- **Penyatuan Mulus Split Button "Backup Inkremental" (Tanpa Celah):**
  - Mengubah wadah tombol menjadi `.btn-group.btn-block` dengan `display: flex;`.
  - Mengatasi margin 1px global dengan `margin: 0 !important;` pada kedua tombol split button serta mengatur sudut sambungan (`border-top-right-radius: 0; border-bottom-right-radius: 0;` pada tombol utama dan `border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: 1px solid rgba(0,0,0,0.15);` pada tombol toggle).
  - Di `admin-style.css`, menambahkan aturan reset margin dan radius untuk `.btn-group > .btn` di dalam tabel serta menonaktifkan `width: 100%` pada `.box-body .btn-group .btn-social` di mobile agar toggle panah tidak terdorong.
  - Hasil: Kedua tombol menyatu sempurna tanpa celah spasi putih, membentuk satu tombol utuh dengan garis pembatas halus.
- **Standarisasi Kolom Tabel Backup:**
  - Memperluas pembungkus tabel dari `col-sm-8` menjadi `col-sm-12 col-md-10 col-lg-9` dan menetapkan lebar kolom tombol tetap `width: 260px;` sehingga ketiga tombol aksi (`Unduh Database`, `Unduh Folder Desa`, dan `Backup Inkremental`) memiliki ukuran proporsional yang sama dan tidak terdesak sempit.
- **Penyatuan Fleksibel Form Restore Database & Folder Desa (Tinggi Seragam 34px):**
  - Menyatukan input-group browse dan tombol *Restore* ke dalam satu baris kontainer flex (`display: flex; align-items: center; gap: 10px;`) di kolom `col-sm-9 col-md-8 col-lg-7`.
  - Menghilangkan celah kosong 30px (column gutter Bootstrap) di antara tombol *Browse* dan *Restore*.
  - Menyelaraskan tinggi seluruh kontrol (input box, tombol *Browse*, dan tombol *Restore*) persis **34px** dengan border-radius 4px yang rapi.
  - Menghapus efek `table-hover` pada pembungkus form agar formulir tidak berubah abu-abu saat kursor melintas.
  - Menghapus kelas `fa-spin` pada tombol restore yang sedang nonaktif (disabled) agar tidak memutar ikon berulang kali seperti indikator loading macet.
  - Merapikan checkbox "Amankan Token Layanan Saat Ini" tepat di bawah input box dan memperbaiki kesalahan ketik atribut `col-lg-5""`.

### Sub-J: Modul Pengaturan QR Code (`/setting/qrcode/clear`)
- **Penanganan Aksi Reset & Pembersihan URL (`/setting/qrcode/clear`):**
  - Pada controller `Setting::qrcode($aksi = '')`, jika `$aksi === 'clear'`, dilakukan redirect otomatis ke `setting/qrcode` untuk mereset formulir dan menjaga URL browser tetap bersih.
  - Inisialisasi default array `$data['qrcode']` dilengkapi dengan key `'isiqr' => ''` dan `'logoqr' => ''` sehingga terhindar dari galat PHP 8 `Undefined array key`.
- **Null-Safety & Pembersihan Tag Blade/PHP:**
  - Mengamankan output form pada view `donjo-app/views/setting/setting_qr.php` dengan operator null-coalescing `?? ''`.
- **Standarisasi Header Box & Tombol Aksi:**
  - Menghilangkan `style="float: right;"` manual dan membungkus tombol *Baru* serta *Scan Baru* menggunakan kontainer standar AdminLTE `<div class="box-tools pull-right">`.
  - Menstandarkan tombol *Scan Baru* menjadi `.btn.btn-social.btn-primary.btn-sm` dengan ikon `<i class="fa fa-refresh"></i>` agar serasi dengan tombol *Baru* di sebelahnya.
- **Perbaikan Grid & Struktur Form:**
  - Menghapus nested `.form-group` ganda pada kolom grid `col-md-4` dan `col-md-8` yang sebelumnya menyebabkan jarak vertikal ganda (30px).
  - Mengubah dropdown *Sisipkan Logo* menjadi dinamis: saat opsi *Otomatis (Logo Desa)* aktif, kolom melebar penuh (`col-md-12`) sehingga label teks panjang tidak terpotong (`Otomatis (Logo v`); saat *Manual* dipilih, kolom menjadi proporsional `col-md-5` dan `col-md-7` berdampingan dengan kotak pemilih berkas.
  - Memperbaiki kotak addon pratinjau warna pada input *Warna Depan* (`my-colorpicker2`) yang sebelumnya patah baris ke atas input akibat `display: inline-flex` dalam `table`, kini distandarkan menjadi flexbox horizontal sejajar (`display: flex !important; width: 100% !important;`) di `admin-style.css`.
  - Memperbaiki kelas CSS tombol yang tumpang-tindih (`btn-info btn-danger` menjadi `btn-danger` dan `btn-info btn-info` menjadi `btn-info`).
- **Responsivitas Pemindai QR & Gambar Hasil:**
  - Mengubah lebar kontainer `#qr-reader` dari ukuran statis (450px / 300px) menjadi dinamis `width: 100%; max-width: 450px; margin: 0 auto;` agar responsif di seluruh resolusi layar ponsel tanpa overflow.
  - Memberikan jarak pemisah vertikal (`margin-bottom: 8px !important;`) pada tombol scanner agar tombol *Scan dari Kamera* dan *Scan dari File* tidak menempel rapat.
  - Memperbaiki path asset GIF scanner (`file-scan.gif` dan `camera-scan.gif`) dari path relatif rapuh `../assets/...` menjadi path absolut dinamis berbasis `BASE_URL` sehingga animasi pemindai berhasil termuat (tidak 404/kosong).
  - Merapikan antarmuka mode *Scan dari File*: menyusun label instruksi berbahasa Indonesia ("Pilih Berkas Gambar QR Code :") di bagian atas dan menstandarkan kotak input berkas dengan border halus, padding, sudut melengkung, serta perataan terpusat (tidak lagi berupa input mentah peramban 200px yang tergeser ke kiri dan label bahasa Inggris terputus).
  - Memperbarui bingkai pemindai dengan border modern `#cbd5e1`, radius 6px, dan latar header `#f8fafc` agar serasi dengan kartu AdminLTE.
  - Mengganti tag `<center>` yang usang (deprecated HTML5) dengan kelas utilitas `.text-center`.
  - Memperbaiki tautan relatif `../../assets/filemanager/...` pada modal iframe menjadi absolut berbasis `base_url('assets/filemanager/dialog.php...')` agar tahan terhadap kedalaman URL rute.
  - Menghapus pemuatan ulang ganda `<script src="jquery.min.js"></script>` pada view yang berisiko merusak plugin jQuery global.

### Sub-K: Modul Optimasi Gambar (`/optimasi_gambar`)
- **Dukungan Penuh Hirarki Folder & Subfolder:**
  - Metode `get_folders()` pada `Optimasi_gambar.php` diperbarui agar memindai struktur direktori `desa/upload/` secara rekursif dengan kedalaman (*depth*), nama folder, dan path relatif lengkap.
  - Sebelumnya, folder bersarang (seperti `desa/upload/gis/area`, `gis/garis`, `gis/lokasi`, dan `gis/lokasi/point` yang menyimpan 638 berkas gambar) sama sekali tidak terdeteksi dan tidak bisa dioptimalkan.
- **Pemeriksaan Gambar Rekursif & Multi-Segmen Rute:**
  - Metode `get_image(...$dirs)` kini menggunakan `RecursiveIteratorIterator` sehingga memindai seluruh berkas gambar di dalam folder beserta seluruh subfoldernya.
  - Menggunakan variadic argument `...$dirs` agar dapat menangkap path rute multi-segmen (misal `/optimasi_gambar/get_image/gis/lokasi/point`) tanpa terpotong di segmen pertama saja.
- **Penyatuan & Tata Letak Tabel Ergonomis:**
  - Menyatukan dua tabel terpisah menjadi satu tabel utuh terpadu dengan baris khusus *Seluruh Folder (desa/upload/)* di baris teratas (badge hijau & tombol *Resize Semua*).
  - Menampilkan struktur pohon direktori (*tree view*) dengan indentasi rapi (`└──`), ikon folder terbuka, penanda label *Subfolder*, dan penebalan nama folder aktif.
  - Memperluas lebar pembungkus dari `col-sm-8` menjadi `col-sm-12 col-md-10 col-lg-9` dengan kolom tombol aksi berukuran tetap `170px` yang rata tegak lurus.
  - **Optimasi Responsif Khusus Mobile (Anti Overflow & Wrapping):**
    - Membungkus tabel dengan `.table-responsive` (`border: none; margin-bottom: 0;`).
    - Menghilangkan redundansi awalan teks `"Folder desa/upload/"` di setiap baris sehingga nama direktori tampil ringkas (`artikel/`, `└── gis/area/`, `└── gis/lokasi/point/`).
    - Menyesuaikan lebar kolom aksi di layar ponsel menjadi kompak (`width: 95px !important;`) dengan label tombol adaptif (`Resize` di ponsel / `Resize Gambar` di desktop; `Semua` di ponsel / `Resize Semua` di desktop).
    - Menyesuaikan besaran indentasi berjenjang (8px, 20px, 32px di ponsel vs 14px, 36px, 58px di PC) dan menyembunyikan badge subfolder sekunder di ponsel agar teks direktori muat dalam satu baris tanpa patah bertumpuk.
  - Menambahkan validasi dialog saat berkas gambar tidak ditemukan (`files.data.length === 0`) agar tidak memunculkan notifikasi selesai palsu.

### Sub-L: Modul Pengaturan Slider Website (`/web/slider`)
- **Desain Kartu Pilihan Sumber Gambar (*Radio Selection Cards*):**
  - Mengubah tampilan tombol radio yang sebelumnya tampak seperti 3 tombol aksi biru terpisah yang membingungkan dengan teks penjelasan menggantung (`</lable>`) menjadi kartu opsi terpadu (*selection card*).
  - Setiap opsi memiliki indikator radio yang otomatis berganti ikon secara dinamis via CSS (`fa-circle-o` saat tidak aktif dan `fa-dot-circle-o` saat aktif), judul opsi yang tebal (*Artikel Terbaru*, *Artikel Terbaru Pilihan*, *Album Galeri*), dan deskripsi penjelasan langsung di dalam kartu.
  - Kartu aktif otomatis mendapatkan highlight latar lembut `#f0f9ff`, border biru primer `#0284c7`, serta bayangan halus.
- **Pembersihan Markup HTML:**
  - Memperbaiki 3 tag penutup salah ketik ilegal `</lable>` menjadi valid.
  - Memperbaiki ketidakseimbangan penutup tag `<div>` pada `.box-body` yang sebelumnya memicu tata letak rusak.
  - Menstandarkan judul card header dengan `<h3 class="box-title"><strong>Sumber Gambar Slider</strong></h3>` dan memindahkan petunjuk pengoperasian ke dalam `.box-body`.
  - Mengeluarkan tombol *Simpan* dari pembungkus `col-xs-12` di dalam `.box-footer` agar aturan responsif box-footer (card-pill penuh di mobile, pull-right di PC) bekerja optimal.

### Sub-M: Modul Pendapat Layanan Mandiri (`/pendapat`)
- **Pembersihan Markup & Struktur HTML:**
  - Menghapus tag penutup `</div>` liar (*stray closing tag*) di akhir view yang sebelumnya merusak layout wrapper AdminLTE.
  - Mengganti tag `<center>` usang (*deprecated HTML5*) pada pembatas grafik menjadi judul heading standar yang bersih.
  - Memperbaiki tautan relatif `href="penduduk/detail/1/0/..."` yang menghasilkan 404 ketika diakses dari rute bersarang, diubah menjadi path absolut `<?= site_url('penduduk/detail/1/0/' . $item['pengguna']) ?>`.
  - Merapikan perataan kolom nama penduduk di tabel rincian agar rata kiri (*left-aligned*) dan tidak lagi dipaksa rata tengah oleh kelas `.padat`.
- **Desain Kartu Emoticon Responsif & Indikator Persentase:**
  - Menata ulang blok persentase kepuasan menggunakan kontainer flex berjarak aman (`gap: 15px; flex-wrap: wrap;`) dengan kartu berlatar halus `#f8fafc`, border `#e2e8f0`, dan sudut melengkung.
  - Menambahkan jumlah perolehan suara di bawah label emoticon (misal `(15 suara)`) dan membatasi tinggi ikon emoticon (`max-height: 54px;`).
  - Di layar ponsel, kartu otomatis tersusun rapi 2x2 tanpa garis pembatas yang patah.
- **Penyempurnaan Filter Periode & Header Responsif:**
  - Menghilangkan posisi absolut bawaan AdminLTE (`position: absolute; right: 10px; top: 5px;`) pada `.box-tools` yang sebelumnya menabrak dan menutupi teks judul panjang *"Tingkat Kepuasan Pengguna Layanan Mandiri"* di layar ponsel.
  - Menerapkan flexbox responsif (`.box-header-pendapat`) dengan `flex-wrap: wrap` dan mematikan pseudo-element `:before` / `:after` Bootstrap:
    - Di layar desktop: Judul di sisi kiri dan tombol filter periode di sisi kanan sejajar dalam 1 baris.
    - Di layar ponsel: Judul membentang penuh (2 baris rapi dengan `line-height: 1.4`) dan tombol filter periode turun ke baris berikutnya di sisi kanan tanpa ada tabrakan/tumpang-tindih sedikit pun.
  - Mengubah penyimpanan periode aktif dari `flashdata` menjadi `session->userdata` agar pilihan filter tidak hilang saat halaman di-refresh, diurutkan (*sorting*), atau dipaginasi.
  - Memperbarui tombol pemilih periode di header menjadi tombol dropdown standar `.btn.btn-social.btn-primary.btn-sm` dengan penanda periode aktif (`class="active"`).
  - Memisahkan judul utama dan teks filter aktif ke baris deskripsi tersendiri untuk mencegah tabrakan judul panjang dengan tombol filter di layar ponsel.
- **Sinkronisasi Emotikon Vektor SVG dengan Layanan Mandiri:**
  - Mengganti pemanggilan gambar raster PNG lama (`assets/images/pendapat/*.png`) dengan 4 emotikon vektor SVG kustom asli persis seperti yang digunakan pada modal Layanan Mandiri (`donjo-app/views/fmandiri/pendapat.php`):
    1. *Sangat Puas*: Emotikon kuning bergradasi hangat dengan mata melengkung riang tertawa, pipi merona merah muda, dan senyum terbuka berlidah riang.
    2. *Puas*: Emotikon kuning cerah dengan senyum bersahabat dan kilau pupil mata putih.
    3. *Cukup*: Emotikon ekspresi tenang netral dengan garis mulut datar lurus.
    4. *Buruk*: Emotikon merah mawar dengan alis tajam condong ke bawah dan bibir melengkung cemberut.
  - Menyelaraskan palet warna grafik batang Highcharts (`#10b981`, `#0ea5e9`, `#f59e0b`, `#f43f5e`) dan badge label status pada tabel rincian (`label-success`, `label-primary`, `label-warning`, `label-danger`) agar seirama dengan identitas visual emotikon masing-masing.

### Sub-N: Modul Pengaturan Layanan Mandiri (`/setting/mandiri`)
- **Pembersihan Markup HTML & Keseimbangan Tag:**
  - Menghapus tag penutup liar `</section></div>` di akhir `@section('content')` pada `index.blade.php` yang sebelumnya menutup paksa pembungkus utama `.content-wrapper` sebelum layout induk selesai.
  - Menstandarkan seluruh header kartu (*Latar Website*, *Latar Login Admin*, *Latar Login Mandiri*, *Pintasan Terkait*, dan *Pengaturan Dasar*) dengan elemen standar AdminLTE `<h3 class="box-title"><strong>...</strong></h3>` menggantikan tag mentah `<b>`.
  - Memperbaiki salah ketik teks alternatif gambar pratinjau `alt="Latar Wesbite"` menjadi `"Latar Login Mandiri"` dan `"Latar Website"`, serta menambahkan border halus dan sudut melengkung pada bingkai pratinjau.
- **Penyempurnaan Input Group Pemilih Berkas Desktop (`index.blade.php` & `admin-style.css`):**
  - Mengeluarkan elemen `<input type="file" class="hidden">` dari dalam pembungkus `.input-group` agar tidak merusak tata letak flexbox dan kalkulasi anak elemen CSS (`:first-child` / `:last-child`).
  - Mengatasi tinggi tombol browse yang sebelumnya jomplang (34px) terhadap input (30px `input-sm`) dan menjorok keluar ke bawah: distandarkan menjadi tinggi seragam 34px presisi sejajar.
  - Menghilangkan celah kosong (*gap*) dan border kanan ganda pada input teks: input kini menyatu rapat dengan tombol (*flush*), sisi kiri melengkung 4px (`border-radius: 4px 0 0 4px`), dan sisi kanan tombol melengkung 4px (`border-radius: 0 4px 4px 0`).
  - Mengganti ikon pencarian off-center mentah `<i class="fa fa-search"></i>&nbsp;` menjadi tombol utuh berlabel profesional `<i class="fa fa-folder-open"></i> Browse` serta menambahkan `placeholder="Pilih berkas..." readonly` dengan kursor pointer interaktif.
- **Penyempurnaan Semantik Form Pengaturan (`form.blade.php`):**
  - Mengganti atribut `for="nama"` yang sebelumnya dipasang acak pada semua label menjadi dinamis `for="{{ $pengaturan->key }}"` sesuai id elemen input masing-masing.
  - Mengubah kolom keterangan pengaturan yang sebelumnya dibungkus tag `<label class="... pull-left" for="nama">` (sehingga seluruh teks bantuan ter-bold tebal seperti judul field) menjadi elemen teks bantuan semantik `<div class="col-sm-12 col-md-5 text-muted">` dengan bobot normal, ukuran 13px, dan spasi vertikal proporsional.
- **Penyempurnaan Widget Pintasan & Skrip Dinamis:**
  - Mengisi area konten *small-box* pintasan (*Pengaturan Surat* & *Syarat Surat*) dengan subjudul penjelasan deskriptif yang rapi menggantikan jeda kosong tag `<br>`.
  - Memperbaiki event handler JavaScript `tampilan_anjungan` agar menggunakan listener jQuery yang kompatibel dengan plugin Select2 dan mencegah galat runtime (*TypeError*) saat elemen tidak ada di halaman.
- **Ketahanan PHP 8 Backend (`Setting_model.php`):**
  - Mengganti pengecekan berkas gambar `$data['latar_*'] != ''` menjadi `!empty($data['latar_*'])` guna mengeliminasi peringatan PHP 8 *Undefined array key* saat modul pengaturan mandiri disimpan.
  - Memastikan nilai berformat array (seperti multi-select) di-encode ke JSON secara aman sebelum melalui pembersihan string, mencegah PHP fatal *TypeError: strip_tags() expects string*.

### Sub-O: Modul Cetak Layanan Surat (`/surat`)
- **Penyelesaian Masalah Tabrakan Tombol Aksi Mobile:**
  - Mengatasi tombol bintang favorit `[ ★ ]` yang sebelumnya melompat keluar kolom dan menimpa teks nama surat di layar HP:
    - Penyebabnya adalah aturan global `.box-body .btn-social { width: 100% !important; }` yang memaksa tombol *Buat Surat* melebar 100% sel `td.aksi`, sehingga tombol favorit kedua terdorong menabrak sel *NAMA SURAT*.
    - Solusinya: Mengelompokkan tombol ke dalam pembungkus `.btn-group-aksi` berjarak rapat (`gap: 4px`) dan mengembalikan `width: auto !important;` pada tombol sosial di dalam tabel.
    - Menstandarkan tombol bintang favorit (`.btn-favorit`) menjadi tombol persegi simetris 32x32px dengan ikon terpusat rapi.
- **Perbaikan Dropdown Pencarian Judul Surat Desktop (`#cetak-surat`):**
  - Mengatasi pembatasan `max-width: 240px` pada container Select2 di header yang sebelumnya memotong teks placeholder menjadi *"--- Cari Judul Surat Yang Akan ..."* dengan sisa ruang kosong 80% di sisi kanannya.
  - Membungkus select2 ke dalam grid responsif `col-xs-12 col-sm-8 col-md-6 col-lg-5` dengan lebar 100% sehingga placeholder terbaca penuh dan nyaman tanpa terpotong di desktop maupun ponsel.
- **Pembaruan Highlight Baris Template Surat Desa (`.select-row`):**
  - Mengganti warna latar baris surat ubahan desa yang sebelumnya menggunakan warna oranye lumpur pekat (`#f8deb5`) menjadi warna amber pastel lembut (`#fffbeb`) dengan hover bersih (`#fef3c7`), sehingga seluruh tabel tidak lagi tampak seperti blok oranye yang melelahkan mata.
  - Menambahkan penanda label status jenis surat pada kolom `JENIS` (`RTF (Desa)` / `TinyMCE (Desa)` berlabel kuning vs `RTF` berlabel default) agar maksud penandaan template kustom desa langsung dipahami pengguna.

### Sub-P: Navigasi Sidebar Responsif & Panel Identitas Desa (`admin-style.css`, `admin.js`, `footer.php`)
- **Penyelesaian Masalah Nama Desa Hilang & Logo Mengecil di Layar Ponsel:**
  - **Akar Masalah:**
    - Aturan CSS mini-sidebar collapse (`.sidebar-collapse .main-sidebar .user-panel > .info { display: none !important; }` dan `.sidebar-collapse .main-sidebar .user-panel > .image > img { max-width: 30px !important; }`) sebelumnya ditulis di luar media query.
    - Ketika status `sidebar-collapse` aktif pada `<body>` (misalnya karena tersimpan di `localStorage` saat browsing di desktop PC), saat sidebar dibuka di layar ponsel (`.sidebar-open`), aturan tersebut memotong nama desa, kecamatan, dan kabupaten (`display: none`), serta menciutkan logo desa menjadi 30px terpusat di tengah laci menu.
  - **Solusi CSS:**
    - Membatasi seluruh aturan mini-sidebar collapsed hanya berjalan pada layar desktop PC (`@media (min-width: 768px)`).
    - Menambahkan penegasan aturan khusus mobile pada `@media (max-width: 767px)` untuk `.sidebar-open .main-sidebar .user-panel` dan `body.sidebar-open.sidebar-collapse .main-sidebar .user-panel`:
      - Menampilkan layout horizontal penuh (`display: flex; flex-direction: row; align-items: center; justify-content: flex-start; gap: 12px; padding: 12px 14px;`).
      - Menampilkan logo desa proporsional (44x44px) di sisi kiri dengan drop shadow halus.
      - Menampilkan teks identitas desa (`.info strong` 13.5px bold putih dan `.wilayah-info` 11.5px soft gray) di samping logo secara utuh tanpa terpotong maupun menghilang.
- **Penyelesaian Masalah Sidebar Kadang Ngebug / Terjebak State Toggle:**
  - **Akar Masalah:**
    - Skrip sinkronisasi `localStorage.getItem('sidebar')` di `assets/js/admin.js` dan `donjo-app/views/footer.php` sebelumnya menambahkan class `sidebar-collapse` secara buta tanpa memeriksa resolusi layar pengguna.
    - Pada layar mobile (< 768px), AdminLTE menggunakan sistem off-canvas drawer (`.sidebar-open`), bukan mini-sidebar (`.sidebar-collapse`). Ketika `sidebar-collapse` ikut tertinggal di `<body>`, terjadi konflik status toggle antara drawer terbuka dan menu collapsed.
  - **Solusi JavaScript:**
    - Membatasi inisialisasi dan persistensi `localStorage` untuk `sidebar-collapse` hanya saat di layar PC/desktop (`window.innerWidth >= 768`).
    - Menghapus class `sidebar-collapse` dari `<body>` secara otomatis ketika aplikasi diakses atau dibuka di perangkat mobile (`window.innerWidth < 768`).
    - Mengikat event listener ke lifecycle event resmi AdminLTE (`collapsed.pushMenu` dan `expanded.pushMenu`) alih-alih mendahului event klik tombol hamburger, sehingga status sidebar selalu tersimpan akurat dan tidak pernah lagi menyebabkan tampilan 'kadang ngebug'.
- **Penyesuaian Ergonomi Menu Sidebar Khusus Layar HP (`admin-style.css`):**
  - **Touch Target Ergonomis:**
    - Menu utama tingkat 1 (`.sidebar-menu > li > a`) ditingkatkan tinggi sentuhannya menjadi `min-height: 44px` dengan `padding: 12px 16px` dan tata letak flexbox rapi (`gap: 10px`).
    - Submenu tingkat 2 (`.treeview-menu > li > a`) yang sebelumnya sangat tipis (hanya 5px padding / ~26px tinggi) diperluas menjadi `min-height: 42px` dengan `padding: 10px 16px 10px 36px` agar jempol pengguna tidak salah sentuh menu bertetangga.
  - **Sinkronisasi Pergeseran Konten (270px):**
    - Mengoreksi pergeseran konten `.content-wrapper` saat drawer terbuka di mobile dari bawaan AdminLTE (230px) menjadi presisi 270px sejajar lebar sidebar (`transform: translate(270px, 0)`), mengeliminasi overlap 40px yang sebelumnya menimpa konten.
    - Menambahkan bayangan drawer yang tegas (`box-shadow: 4px 0 25px rgba(0, 0, 0, 0.4)`) dan backdrop overlay gelap semi-transparan (`rgba(0, 0, 0, 0.35)`) di atas konten latar belakang saat sidebar aktif.
  - **Scroll Halus & Form Pencarian Menu:**
    - Mengaktifkan `-webkit-overflow-scrolling: touch` dan `overflow-y: auto` pada container sidebar agar navigasi menu di layar sentuh terasa mulus dan responsif tanpa hambatan.
    - Mengoptimasi form pencarian menu `#cari-menu` di HP dengan tinggi input 38px, font 13.5px yang tajam, dan tombol search yang proporsional.





