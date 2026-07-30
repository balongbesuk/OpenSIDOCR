# 🚀 OpenSID Custom (Desa Balongbesuk)

[![OpenSID Version](https://img.shields.io/badge/Base_OpenSID-v2403.0.0-blue.svg)](https://github.com/OpenSID/OpenSID)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%20%7C%208.3-777BB4.svg)](https://www.php.net/)
[![AI Engine](https://img.shields.io/badge/AI_Engine-RapidOCR_ONNX-success.svg)](https://github.com/RapidAI/RapidOCR)
[![Regulation](https://img.shields.io/badge/Permendagri-No._108_Tahun_2019-orange.svg)](https://peraturan.go.id/)

Aplikasi **OpenSID Custom** ini merupakan versi pengembangan mutakhir dari **OpenSID v2403.0.0** yang dilengkapi dengan **fitur-fitur inovatif kependudukan tingkat lanjut** yang **TIDAK DIMILIKI oleh OpenSID Bawaan (Standar)**. 

Diperuntukkan untuk meningkatkan efisiensi kerja operator desa hingga **90%**, menjamin kepatuhan regulasi Ditjen Dukcapil Kemendagri, serta mengotomatisasi pemrosesan data kependudukan.

---

## 🌟 Komparasi Fitur: OpenSID Standar vs OpenSID Custom

| Fitur / Kemampuan | ❌ OpenSID Standar (Bawaan) | 🚀 OpenSID Custom (Versi Ini) |
| :--- | :--- | :--- |
| **Impor KK dari Foto / Scan Fotokopi** | Tidak Bisa (Hanya PDF e-KK digital) | **Bisa 100% (Support PDF, JPG, JPEG, PNG)** via RapidOCR ONNX AI |
| **Proses Pindah Penduduk Keluarga** | Wajib ubah status dasar 1 per 1 | **Batch Pindah Kolektif (1 KK / Sebagian)** dalam 1 Form |
| **Aturan Pecah KK Sisa (Permendagri 108/2019)** | Tidak Ada (Sisa anggota rawan berantakan) | **Otomatis Dibuatkan KK Baru + No. KK Sementara + Kepala KK Baru** |
| **Normalisasi Data Pendidikan DIPLOMA I/II** | 🐛 Bug Collide ke DIPLOMA III (ID 7) | **Presisi 100% tersimpan ke DIPLOMA I/II (ID 6)** |
| **Status Perkawinan "CERAI BELUM TERCATAT"** | Tidak terbaca / Kosong | **Terbaca dan Terpetakan Presisi ke Database** |
| **Pemisahan Nama Rapat Akibat OCR Fotokopi** | Tidak Ada (Nama menjadi gabung/tanpa spasi) | **Indonesian Name Word Splitter** (`INTANRAHMAWATI` $\rightarrow$ `INTAN RAHMAWATI`) |
| **Instalasi Engine AI / OCR** | Kompleks & Butuh API Cloud | **1-Click Engine Installer (Bawaan Modal Admin & Web)** |

---

## 🔥 Fitur Unggulan Utama (Tidak Dimiliki OpenSID Bawaan)

### 1. 🚚 Fitur Pindah Penduduk Kolektif (1 KK / Pindah Sebagian) & Otomatisasi Permendagri 108/2019
* **Single Batch Relocation Form**: Operator tidak perlu lagi mengubah status dasar *Pindah* satu per satu untuk setiap anggota keluarga. Cukup centang anggota keluarga yang pindah dan isi formulir kepindahan **1 kali**.
* **Kepatuhan Permendagri No. 108 Tahun 2019**:
  * Jika **Kepala KK lama ikut pindah** dan terdapat **anggota keluarga yang ditinggalkan**, sistem secara otomatis membentuk **Kartu Keluarga Baru (No. KK Sementara)** untuk sisa anggota tersebut.
  * Sistem secara cerdas menyarankan **Kepala Keluarga Baru dari anggota tersisa yang tertua**, serta menyediakan *dropdown selection* jika operator ingin menentukan Kepala KK Baru lain berdasarkan kesepakatan keluarga.
  * Seluruh mutasi dieksekusi secara atomic dalam *Database Transaction* (`$this->db->trans_start()`) dan memperbarui `log_penduduk` serta `log_keluarga`.

---

### 2. 📸 Engine Impor Scan / Foto KK via AI (RapidOCR ONNX Engine)
* **Pembeda Utama dari OpenSID Standar**: OpenSID standar hanya bisa mengimpor PDF KK elektronik dari Dukcapil. Versi Custom ini sanggup membaca **hasil foto kamera HP atau scan fotokopi KK kertas (`.jpg`, `.jpeg`, `.png`, `.pdf`)**.
* **Engine OCR Lokal Super Cepat & Offline**: Menggunakan **RapidOCR ONNX Engine** yang berjalan 100% lokal di server tanpa ketergantungan API cloud berbayar.
* **Fitur Auto-Rotation & Multi-Angle Retry**: Otomatis memutar dan memproses gambar miring/terbalik (+90°, -90°, 180°) untuk akurasi pembacaan tertinggi.
* **Indonesian Name Word Splitter**: Algoritma pintar memisahkan nama Indonesia yang tercetak rapat tanpa spasi akibat hasil cetak/scan fotokopi kusam (contoh: `INTANRAHMAWATI` $\rightarrow$ `INTAN RAHMAWATI`).
* **Pemeta Presisi Orang Tua (Ayah / Ibu)**: Algoritma cerdas memisahkan nama Ayah dan Ibu hingga 3 suku kata pada Tabel 2 KK.

---

### 3. 🎓 Perbaikan Bug Pemetaan Pendidikan `DIPLOMA I/II` & Status Perkawinan `CERAI BELUM TERCATAT`
* **Solusi String Collision ID 6 vs ID 7**: Pada OpenSID standar, fungsi pembersihan string menghapus garis miring dan spasi dari `"DIPLOMA I / II"`, mengubahnya menjadi `"DIPLOMAIII"` sehingga bertabrakan dengan `"DIPLOMA III"` dan salah tersimpan sebagai ID 7 (`AKADEMI/ DIPLOMA III`). Versi Custom ini melengkapi `$norm_clean_pend` yang menjamin `DIPLOMA I/II` tersimpan secara presisi ke **ID 6**.
* **Dukungan Status Perkawinan Baru**: Ekstraksi dan pemetaan otomatis status `"CERAI BELUM TERCATAT"` pada impor KK PDF maupun Scan OCR.

---

## 📦 Tutorial Instalasi Engine RapidOCR

Engine RapidOCR dapat dipasang di server Anda melalui **3 metode mudah**:

### 🌟 Metode 1: 1-Click Installer di Pop-up Modal OpenSID (Paling Praktis)
1. Masuk ke Admin OpenSID $\rightarrow$ Menu **Kependudukan** $\rightarrow$ **Keluarga**.
2. Klik **Tambah KK Baru** $\rightarrow$ pilih **Impor Scan / Foto KK (OCR)**.
3. Jika engine belum terpasang, klik tombol:  
   `[ 📥 Install Engine RapidOCR Sekarang (1-Click) ]`
4. Tunggu 10-30 detik hingga proses pengunduhan selesai otomatis.

---

### 🌐 Metode 2: 1-Click Browser Installer (`install_ocr.php`)
1. Akses file `install_ocr.php` melalui browser:
   ```text
   https://domain-anda.com/install_ocr.php
   ```
2. Script akan otomatis mengunduh dependensi `rapidocr_onnxruntime` & `opencv-python-headless` yang sesuai dengan OS server Anda.

---

### 💻 Metode 3: Instalasi Manual via Terminal SSH / Windows
- **Server Linux / cPanel (VPS)**:
  ```bash
  pip3 install --user --upgrade opencv-python-headless rapidocr_onnxruntime
  ```
- **Local Windows Server (XAMPP / Laragon)**:  
  Sudah menyertakan biner portabel `bin/rapidocr/win64/rapidocr.exe` (**Langsung aktif 100% tanpa perlu instalasi apapun**).

---

## 🛠️ Spesifikasi & Persyaratan Sistem
- **Versi Basis**: OpenSID v2403.0.0
- **PHP**: PHP 7.4 / PHP 8.1 / PHP 8.3
- **Database**: MySQL 5.7+ / MariaDB / MySQL 8.4
- **Engine OCR**: RapidOCR ONNX Runtime

---

## 📜 Lisensi & Pengembang

- **OpenSID**: Dikembangkan oleh Komunitas OpenSID ([https://github.com/OpenSID/OpenSID](https://github.com/OpenSID/OpenSID)) di bawah lisensi GNU General Public License v3.0 (GPLv3).
- **RapidOCR**: Engine OCR berbasis ONNX Runtime oleh RapidAI ([https://github.com/RapidAI/RapidOCR](https://github.com/RapidAI/RapidOCR)).
- **Custom Modul & Fitur Unggulan**: Dikembangkan oleh Tim Desa Balongbesuk / OpenSID Custom.
