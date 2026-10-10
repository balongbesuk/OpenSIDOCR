# OpenSID Custom - Impor Scan / Foto KK (RapidOCR ONNX Engine)

Aplikasi **OpenSID Custom** ini merupakan versi modifikasi dari **OpenSID v2403.0.0** yang dikembangkan khusus untuk mempermudah dan mempercepat proses impor data Kartu Keluarga (KK) dari dokumen cetak/scan menggunakan teknologi kecerdasan buatan **RapidOCR ONNX Engine**.

---

## 📦 Tutorial Instalasi Engine RapidOCR

Engine RapidOCR dapat terpasang di server Anda melalui salah satu dari **3 metode mudah** di bawah ini:

### 🌟 Metode 1: 1-Click Installer di Pop-up Modal OpenSID (Paling Mudah)
1. Masuk ke halaman admin OpenSID $\rightarrow$ Menu **Kependudukan** $\rightarrow$ **Keluarga**.
2. Klik tombol **Tambah KK Baru** $\rightarrow$ pilih **Impor Scan / Foto KK (OCR)**.
3. Status engine akan otomatis dideteksi:
   - Jika belum terpasang: muncul tombol `[ 📥 Install Engine RapidOCR Sekarang (1-Click) ]`.
   - Jika masih menggunakan versi lama: muncul tombol `[ 🚀 Upgrade ke PP-OCRv4 & OpenCV ]`.
   - Jika sudah versi terbaru: status menunjukkan `Ready (RapidOCR PP-OCRv4 + OpenCV Preprocessing ✅)`.
4. Klik tombol instalasi/upgrade, tunggu 15-40 detik hingga proses download selesai otomatis.

---

### 🌐 Metode 2: 1-Click Browser Installer (`install_ocr.php`)
1. Unggah file `install_ocr.php` ke folder utama web hosting Anda (`public_html/install_ocr.php`).
2. Akses file tersebut melalui browser:
   ```text
   https://domain-anda.com/install_ocr.php
   ```
3. Script akan otomatis mengunduh paket `rapidocr` (PP-OCRv4) & `opencv-python-headless` yang sesuai dengan OS server Anda via fungsi PHP `exec()`.
4. Setelah muncul pesan **🎉 BERHASIL**, Anda dapat menghapus file `install_ocr.php` demi keamanan.

---

### 💻 Metode 3: Instalasi Manual via Terminal SSH / Command Line
Jika Anda memiliki akses terminal SSH di VPS/Server:
- **Di Linux Server / VPS (Ubuntu / Debian / cPanel)**:
  ```bash
  pip3 install --user --upgrade rapidocr opencv-python-headless pymupdf
  ```
- **Di Local Windows Server (XAMPP / Laragon)**:
  ```bash
  pip install --upgrade rapidocr opencv-python-headless pymupdf
  ```
  *(Sistem juga mendukung fallback ke binary lokal `bin/rapidocr/win64/rapidocr.exe` jika tersedia)*.

---

## 🎯 Fitur Unggulan Custom

### 1. Engine AI OCR Super Cepat & Lokal (RapidOCR PP-OCRv4 Model)
- Menggunakan arsitektur Deep Learning **PP-OCRv4 Latin Model** dari RapidOCR yang sangat ringan, cepat (< 2-3 detik), dan akurat mengenali teks bahasa Indonesia.
- Kompatibel penuh dengan paket Python `rapidocr` versi terbaru maupun versi lama `rapidocr_onnxruntime`.
- Berjalan 100% lokal di server Anda tanpa biaya API pihak ketiga, menjaga privasi kerahasiaan data kependudukan.

### 2. Pra-pemrosesan Citra Cerdas (OpenCV CLAHE & Auto-Orientation)
- **Contrast Limited Adaptive Histogram Equalization (CLAHE)**: Meningkatkan kontras lokal pada foto KK yang gelap, buram, atau kurang pencahayaan.
- **Mild Sharpening Filter**: Mempertajam tepi huruf/angka tipis pada cetakan fotokopi KK.
- **Auto-Orientation & Landscape Fix**: Otomatis mendeteksi dokumen foto tegak (portrait) dan memutarnya ke posisi standar horizontal (landscape).
- **Mesin Auto-Rotation Retry Multi-Sudut**: Jika dokumen terbalik, sistem otomatis mencoba sudut rotasi alternatif (+90°, -90°, 180°).

### 3. Kompatibilitas Multi-Format File (`.pdf`, `.jpg`, `.jpeg`, `.png`)
- Mendukung berkas **PDF Scan (`.pdf`)** maupun file **Gambar (`.jpg`, `.jpeg`, `.png`)**.
- Untuk berkas PDF scan, halaman pertama langsung diekstrak secara otomatis menggunakan rendering resolusi tinggi 300 DPI (via PyMuPDF) atau ekstraksi stream gambar internal.

### 4. Smart Parser & Pemetaan Data Presisi Tinggi
- **Word-Boundary Pendidikan & Profesi**: Mencegah salah deteksi pendidikan `SLTA` akibat singkatan `MA` pada nama penduduk (seperti Marsini, Madiun) atau kata `TAMAT`.
- **Deteksi Pekerjaan Akurat**: Memprioritaskan `MENGURUS RUMAH TANGGA` sebelum `GURU`, serta mengenali `BURUH HARIAN LEPAS` (termasuk deteksi rapat OCR `BURUHHARIAN LEPAS`), `BURUH TANI`, `BURUH NELAYAN`, `PNS`, `TNI`, `POLRI`, `SOPIR`, dan pekerjaan umum lainnya.
- **Indonesian Name Word Splitter**: Pemecahan otomatis suku kata nama Indonesia yang rapat tanpa spasi akibat hasil scan fotokopi (contoh: `INTANRAHMAWATI` $\rightarrow$ `INTAN RAHMAWATI`).
- **Pemetaan Presisi Nama Orang Tua (Ayah / Ibu)**: Algoritma pemisahan nama orang tua yang presisi (contoh: Ayah = `BASORI`, Ibu = `NING AMAH`).
- **Dukungan Titik Dua Unicode (`:`, `：`, `=`, `＝`)**: Mengenali variasi simbol titik dua pada bidang Header (RT/RW, Desa, Kecamatan, Alamat).
- **Y-Axis Clustering Dinamis**: Menjaga keutuhan baris data anggota keluarga pada dokumen resolusi tinggi.

### 5. Ubah Status Dasar Pindah Kolektif (Satu KK / Pindah Sebagian) & Permendagri 108/2019
- **Single Batch Relocation Form**: Memproses pengubahan status dasar `PINDAH` sekaligus untuk seluruh anggota keluarga (1 KK) atau sebagian anggota keluarga yang dicentang (*checkbox*) dalam 1 formulir terpadu.
- **Otomatisasi Pecah KK & No. KK Sementara (Permendagri No. 108/2019)**: Jika Kepala KK lama ikut pindah dan ada anggota keluarga yang ditinggalkan, sistem secara otomatis membuatkan **Kartu Keluarga Baru (No. KK Sementara)** untuk sisa anggota tersebut.
- **Smart Selection Kepala KK Baru**: Otomatis menyarankan anggota tersisa yang tertua (atau dapat dipilih via *dropdown* oleh operator).
- **Aksi Cepat Menu**: Menyediakan tombol `[ 🚚 Pindah KK / Sebagian ]` pada halaman rincian anggota keluarga dan tabel data keluarga.

### 6. Visualisasi Statistik Desa Interaktif & Cetak Resmi (SEO Friendly)
- **Rute URL SEO-Friendly**: Mendukung URL bersih berbasis slug untuk seluruh indikator kependudukan seperti `/data-statistik/pekerjaan`, `/data-statistik/rentang-umur`, `/daftar-pemilih-tetap`, dan `/perkembangan-penduduk`.
- **Filter Wilayah Bertingkat (Cascading AJAX)**: Penyaringan data demografi berdasarkan Dusun, RW, dan RT secara langsung tanpa memuat ulang seluruh halaman.
- **Toolbar Grafik Responsif & Sejajar**: Beralih antarmuka grafik batang, lingkaran (*pie*), dan garis (*line*) dengan preservasi query filter aktif serta tampilan tombol cetak yang sejajar rapi.
- **Laporan Cetak Resmi Standar A4**: Fitur cetak terintegrasi yang otomatis menampilkan Kop Surat Pemerintahan Desa, cakupan wilayah terpilih, membuka seluruh baris data rincian, menyembunyikan elemen web, serta menyertakan lembar tanda tangan pengesahan Kepala Desa.

---

## 🛠️ Versi Basis Aplikasi
- **Versi Basis**: **OpenSID v2403.0.0**
- **Framework**: CodeIgniter 3 / PHP 7.4+
- **Database**: MySQL / MariaDB

---

## 🚀 Cara Penggunaan Aplikasi

### 📄 Impor Scan / Foto KK (OCR)
1. Masuk ke menu **Kependudukan** $\rightarrow$ **Keluarga**.
2. Klik tombol **Tambah KK Baru** $\rightarrow$ pilih **Impor Scan / Foto KK (OCR)**.
3. Unggah file dokumen Kartu Keluarga (format `.pdf`, `.jpg`, `.jpeg`, atau `.png`).
4. Klik **Unggah & Scan OCR**.
5. Periksa pratinjau data Header KK & Anggota Keluarga yang terekstrak, lalu klik **Simpan ke Database**.

### 🚚 Pindah Penduduk Kolektif (Satu KK / Pindah Sebagian)
1. Masuk ke menu **Kependudukan** $\rightarrow$ **Keluarga**.
2. Buka **Rincian Anggota Keluarga** atau klik ikon `🚚` pada kolom aksi tabel KK.
3. Klik tombol **`[ 🚚 Pindah KK / Sebagian ]`**.
4. Centang anggota keluarga yang akan dipindahkan (jika Kepala KK pindah sebagian, tentukan Kepala KK Baru untuk sisa anggota keluarga pada dropdown yang muncul).
5. Isi data kepindahan (Tujuan Pindah, Tanggal Peristiwa, Tanggal Lapor, Alamat Tujuan, No. SKP/Catatan).
6. Klik **Simpan & Proses Kepindahan**.

---

## 📜 Lisensi & Credit

- **OpenSID**: Dikembangkan oleh Komunitas OpenSID ([https://github.com/OpenSID/OpenSID](https://github.com/OpenSID/OpenSID)) di bawah lisensi GNU General Public License v3.0 (GPLv3).
- **RapidOCR**: Engine OCR berbasis ONNX Runtime oleh RapidAI ([https://github.com/RapidAI/RapidOCR](https://github.com/RapidAI/RapidOCR)).
- **Custom Modul Impor OCR & Pindah KK**: Dikembangkan oleh Tim Desa Balongbesuk / OpenSID Custom.
