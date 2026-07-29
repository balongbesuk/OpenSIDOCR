# OpenSID Custom - Impor Scan / Foto KK (RapidOCR ONNX Engine)

Aplikasi **OpenSID Custom** ini merupakan versi modifikasi dari **OpenSID v2403.0.0** yang dikembangkan khusus untuk mempermudah dan mempercepat proses impor data Kartu Keluarga (KK) dari dokumen cetak/scan menggunakan teknologi kecerdasan buatan **RapidOCR ONNX Engine**.

---

## 🎯 Fitur Unggulan Custom

### 1. Engine OCR Super Cepat & Lokal (RapidOCR ONNX Engine)
- Menggantikan Tesseract OCR bawaan dengan **RapidOCR ONNX Engine** (`bin/rapidocr/win64/rapidocr.exe`).
- Berjalan sepenuhnya secara lokal tanpa ketergantungan pada *cloud API* maupun instalasi dependensi tambahan.

### 2. Kompatibilitas Multi-Format File (`.pdf`, `.jpg`, `.jpeg`, `.png`)
- Mendukung pengunggahan berkas berbentuk **PDF Scan (`.pdf`)** maupun **Gambar (`.jpg`, `.jpeg`, `.png`)**.
- **Mesin Auto-Rotation Retry Multi-Sudut**: Secara otomatis mendeteksi dan memutar berkas terbalik atau miring (ke sudut +90°, -90°, atau 180°) untuk memastikan keterbacaan data 100%.

### 3. Dukungan Kompatibilitas Ganda Format KK
- **KK Format Lama (TTD Manual & Stempel Disdukcapil)**:
  - Menyaring NIP 18-digit pejabat pada kaki dokumen agar tidak keliru terbaca sebagai Nomor KK / NIK.
- **KK Format Baru (Barcode TTE BSrE BSSN)**:
  - Ekstraksi otomatis kolom **Tanggal Perkawinan / Perceraian** ke format baku ISO (`YYYY-MM-DD`).

### 4. Smart Parser & Pengolah Teks Otomatis
- **Indonesian Name Word Splitter**: Pemecahan otomatis suku kata nama Indonesia yang rapat tanpa spasi akibat hasil scan fotokopi (contoh: `INTANRAHMAWATI` $\rightarrow$ `INTAN RAHMAWATI`).
- **Pemetaan Presisi Nama Orang Tua (Ayah / Ibu)**: Algoritma pemisahan nama orang tua yang presisi (contoh: Ayah = `BASORI`, Ibu = `NING AMAH`).
- **Dukungan Titik Dua Unicode (`:`, `：`, `=`, `＝`)**: Mengenali variasi simbol titik dua pada bidang Header (RT/RW, Desa, Kecamatan, Alamat).
- **Y-Axis Clustering Dinamis (22px)**: Menjaga keutuhan baris data anggota keluarga pada dokumen resolusi tinggi.

---

## 🛠️ Versi Basis Aplikasi
- **Versi Basis**: **OpenSID v2403.0.0**
- **Framework**: CodeIgniter 3 / PHP 7.4+
- **Database**: MySQL / MariaDB

---

## 🚀 Cara Penggunaan Fitur Impor Scan KK (OCR)

1. Masuk ke menu **Kependudukan** $\rightarrow$ **Keluarga**.
2. Klik tombol **Tambah KK Baru** $\rightarrow$ pilih **Impor Scan / Foto KK (OCR)**.
3. Unggah file dokumen Kartu Keluarga (format `.pdf`, `.jpg`, `.jpeg`, atau `.png`).
4. Klik **Unggah & Scan OCR**.
5. Periksa pratinjau data Header KK & Anggota Keluarga yang terekstrak, lalu klik **Simpan ke Database**.

---

## 📜 Lisensi & Credit

- **OpenSID**: Dikembangkan oleh Komunitas OpenSID ([https://github.com/OpenSID/OpenSID](https://github.com/OpenSID/OpenSID)) di bawah lisensi GNU General Public License v3.0 (GPLv3).
- **RapidOCR**: Engine OCR berbasis ONNX Runtime oleh RapidAI ([https://github.com/RapidAI/RapidOCR](https://github.com/RapidAI/RapidOCR)).
- **Custom Modul Impor OCR**: Dikembangkan oleh Tim Desa Balongbesuk / OpenSID Custom.
