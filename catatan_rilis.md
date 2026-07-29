# Catatan Rilis Fitur Custom OpenSID

Dokumen ini mencatat seluruh penambahan fitur dan perbaikan khusus (*custom*) yang dikembangkan untuk sistem OpenSID.

---

## Versi Custom 2403.0.0 (Fitur Impor Scan / Foto KK OCR)

### 🚀 Penambahan Fitur Custom

1. **Migrasi & Integrasi Engine OCR Tercepat (RapidOCR ONNX Engine)**
   - Menggantikan Tesseract OCR bawaan dengan **RapidOCR ONNX Engine** lokal (`bin/rapidocr/win64/rapidocr.exe` di Windows) dan paket PyPI `rapidocr_onnxruntime` + `opencv-python-headless` di Linux.
   - Pembacaan teks sangat cepat tanpa ketergantungan pada *cloud API* eksternal.

2. **Deteksi Otomatis & Fitur 1-Click Installer di Pop-up Modal**
   - **Indikator Status Real-time**: Menampilkan badge status engine OCR (Ready ✅ / Belum Terpasang ⚠️) secara otomatis pada modal impor.
   - **Tombol 1-Click Installer AJAX**: Jika engine belum terpasang di cPanel/Linux, tombol install 1-klik akan otomatis memasang `rapidocr_onnxruntime` & `opencv-python-headless` via PHP `exec()` tanpa perlu SSH terminal.
   - **Standalone Installer Script (`install_ocr.php`)**: Script pembantu instalasi 1-klik yang dapat diakses langsung via browser (`domain.com/install_ocr.php`).

3. **Dukungan Format Berkas PDF & Gambar**
   - Mendukung pengunggahan berkas **PDF Scan (`.pdf`)** serta **Gambar (`.jpg`, `.jpeg`, `.png`)**.
   - Penambahan **Mesin Multi-Angle Auto-Rotation Retry** yang secara otomatis mendeteksi dan memutar orientasi berkas (ke sudut +90°, -90°, atau 180°) jika dokumen diunggah miring/terbalik.

4. **Dukungan Kompatibilitas Ganda Format Kartu Keluarga**
   - **KK Format Lama**: Mendukung ekstraksi data pada KK dengan pengesahan TTD Manual & Stempel Basah Disdukcapil (penyaringan NIP 18-digit pejabat otomatis agar tidak mengontaminasi No KK).
   - **KK Format Baru**: Mendukung ekstraksi data pada KK dengan Tanda Tangan Elektronik (Barcode TTE BSrE BSSN) dan ekstraksi otomatis kolom **Tanggal Perkawinan / Perceraian**.

5. **Kecerdasan Ekstraksi & Penyempurnaan Teks (Smart Parser)**
   - **Pemisah Spasi Nama Rapat**: Pemecahan otomatis suku kata nama Indonesia yang rapat tanpa spasi akibat hasil pemindaian fotokopi (contoh: `INTANRAHMAWATI` $\rightarrow$ `INTAN RAHMAWATI`).
   - **Pemetaan Presisi Nama Orang Tua (Ayah / Ibu)**: Algoritma pemisahan nama orang tua yang akurat dengan penyaringan sub-header tabel 2 serta pemetaan pintar nama 3 kata (contoh: Ayah: `BASORI`, Ibu: `NING AMAH`).
   - **Dukungan Titik Dua Unicode (`:`, `：`, `=`, `＝`)**: Mengenali berbagai variasi titik dua hasil OCR pada bidang Header (RT/RW, Desa, Kecamatan, Alamat).
   - **Pengelompokan Baris Vertikal Dinamis (22px)**: Mencegah terpisahnya baris data anggota keluarga pada dokumen berkepadatan tinggi.
   - **Dukungan Path cPanel User Home**: Deteksi otomatis biner eksekusi pengguna Linux cPanel (`~/.local/bin/rapidocr`) dan eksekusi langsung via Python 3 import.