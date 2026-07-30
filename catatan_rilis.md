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

3. **Pembatasan Hak Akses Khusus Administrator**
   - **Backend Protection**: Metode `dialog_import_scan_kk()`, `ajax_install_ocr()`, dan `proses_import_scan_kk()` dikunci ketat khusus untuk pengguna dengan grup Administrator (`$admin_only = true`).
   - **Frontend Protection**: Tombol menu *Impor Scan / Foto KK (OCR)* disembunyikan secara otomatis untuk pengguna non-administrator.

4. **Dukungan Format Berkas PDF & Gambar**
   - Mendukung pengunggahan berkas **PDF Scan (`.pdf`)** serta **Gambar (`.jpg`, `.jpeg`, `.png`)**.
   - Penambahan **Mesin Multi-Angle Auto-Rotation Retry** yang secara otomatis mendeteksi dan memutar orientasi berkas (ke sudut +90°, -90°, atau 180°) jika dokumen diunggah miring/terbalik.

5. **Dukungan Kompatibilitas Ganda Format Kartu Keluarga**
   - **KK Format Lama**: Mendukung ekstraksi data pada KK dengan pengesahan TTD Manual & Stempel Basah Disdukcapil (penyaringan NIP 18-digit pejabat otomatis agar tidak mengontaminasi No KK).
   - **KK Format Baru**: Mendukung ekstraksi data pada KK dengan Tanda Tangan Elektronik (Barcode TTE BSrE BSSN) dan ekstraksi otomatis kolom **Tanggal Perkawinan / Perceraian**.

6. **Kecerdasan Ekstraksi & Penyempurnaan Teks (Smart Parser)**
   - **Pengelompokan Baris Vertikal Proporsional**: Formula toleransi tinggi baris ($yThreshold$) yang dihitung secara dinamis dan proporsional terhadap tinggi resolusi dokumen, menjamin presisi 100% pada file gambar biasa maupun PDF resolusi tinggi.
   - **Pemisah Spasi Nama Rapat**: Pemecahan otomatis suku kata nama Indonesia yang rapat tanpa spasi akibat hasil pemindaian fotokopi (contoh: `INTANRAHMAWATI` $\rightarrow$ `INTAN RAHMAWATI`).
   - **Pemetaan Presisi Nama Orang Tua (Ayah / Ibu)**: Algoritma pemisahan nama orang tua yang akurat dengan penyaringan sub-header tabel 2 serta pemetaan pintar nama 3 kata (contoh: Ayah: `BASORI`, Ibu: `NING AMAH`).
   - **Dukungan Titik Dua Unicode (`:`, `：`, `=`, `＝`) & NamaKepala**: Mengenali berbagai variasi titik dua dan penggabungan kata hasil OCR pada bidang Header (RT/RW, Desa, Kecamatan, Alamat, Kepala Keluarga).
   - **Dukungan Path cPanel User Home**: Deteksi otomatis biner eksekusi pengguna Linux cPanel (`~/.local/bin/rapidocr`) dan eksekusi langsung via Python 3 import.

---

## Versi Custom 2403.0.1 (Perbaikan Impor PDF/Scan KK)

### 🐛 Perbaikan Bug & Penyempurnaan Parser KK

1. **Perbaikan Pembacaan & Pemetaan Status Perkawinan `CERAI BELUM TERCATAT`**
   - Menambahkan `'CERAI BELUM TERCATAT'` ke dalam daftar referensi status perkawinan pada `App\Libraries\KkPdfParser` dan `App\Libraries\KkScanOcrParser`.
   - Memastikan status perkawinan "CERAI BELUM TERCATAT" dari kolom (10) Kartu Keluarga elektronik maupun scan terbaca dengan presisi dan tidak menjadi kosong di pratinjau maupun database.

2. **Perbaikan Pemetaan & Penyimpanan Tingkat Pendidikan `DIPLOMA I/II`**
   - Mengatasi masalah tabrakan kunci normalisasi string (*string collision*) pada `Keluarga.php` di mana kunci normalisasi `"DIPLOMA I / II"` sebelumnya menghasilkan string `"DIPLOMAIII"`, yang menyebabkan tertimpa oleh ID `7` (`AKADEMI/ DIPLOMA III/S. MUDA`) dan gagal tersimpan sebagai ID `6` (`DIPLOMA I / II`).
   - Menambahkan fungsi normalisasi khusus `$norm_clean_pend` yang memisahkan kunci `DIPLOMA I/II` (`DIPLOMAI_II`) dan `DIPLOMA III` (`DIPLOMAIII`) sehingga data pendidikan `DIPLOMA I/II` tersimpan secara presisi ke database `tweb_penduduk` (`pendidikan_kk_id = 6`).
   - Menyempurnakan deteksi tingkat pendidikan pada `KkScanOcrParser.php`.

### 🚀 Fitur Baru: Pindah Penduduk Kolektif (Satu KK / Pindah Sebagian)

1. **Fitur Ubah Status Dasar Pindah Kolektif (Batch Family Relocation)**
   - Menambahkan fitur pengubahan status dasar `PINDAH` sekaligus untuk seluruh anggota keluarga (1 KK) atau sebagian anggota keluarga yang dicentang (*checkbox*) dalam 1 formulir terpadu (*Single Batch Form*).
   - Menyediakan tombol aksi `[ 🚚 Pindah KK / Sebagian ]` pada Halaman Anggota Keluarga (`keluarga/anggota`) dan Tabel Data Keluarga (`keluarga`).

2. **Otomatisasi Pecah KK & Pembuatan No. KK Sementara Sesuai Permendagri No. 108/2019**
   - Apabila Kepala Keluarga lama ikut pindah dan terdapat sisa anggota keluarga yang ditinggalkan (tidak pindah), sistem secara otomatis membuatkan **Kartu Keluarga Baru (No. KK Sementara)** untuk sisa anggota tersebut.
   - Sistem menyarankan secara otomatis Kepala KK Baru dari **anggota tersisa yang tertua**, serta memberikan *dropdown select* bagi operator jika ingin menentukan Kepala KK Baru lain berdasarkan kesepakatan keluarga.
   - Seluruh transaksi mutasi dilakukan secara aman dalam *Database Transaction* (`$this->db->trans_start()`) dan memperbarui `log_penduduk` serta `log_keluarga`.
   - Mengatasi masalah evaluasi kunci status dasar anggota tersisa sehingga alur pemecahan KK Baru berjalan 100% presisi.

3. **Penyempurnaan UI Modal & Penyelarasan Datepicker**
   - Perombakan tampilan modal dialog `ajax_pindah_kk_form.php` agar 100% seragam dengan desain form bawaan OpenSID AdminLTE (`box box-danger`, header tabel `bg-gray disabled color-palette`, dan tombol `btn-social btn-flat`).
   - Penyelarasan format tanggal peristiwa dan tanggal lapor menggunakan format Indonesia `DD-MM-YYYY`.

4. **Proteksi Helper Autocomplete (`opensid_helper.php`)**
   - Menambahkan *guard check* `if (empty($data) || !is_array($data) ...)` pada fungsi `autocomplete_data_ke_str()` untuk mencegah error `array_keys()` null argument pada PHP 8.3+.

5. **Pemberharuan Dokumentasi Utama (`README.md`)**
   - Memperbarui `README.md` dengan penekanan pada fitur-fitur unggulan kependudukan mutakhir yang tidak dimiliki OpenSID standar (Batch Pindah 1 KK/Sebagian, Otomatisasi Permendagri 108/2019, Engine Impor Scan KK via RapidOCR ONNX, serta Perbaikan Pemetaan Pendidikan & Status Perkawinan).