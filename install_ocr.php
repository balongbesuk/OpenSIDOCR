<?php
/**
 * Script Pembantu Instalasi & Verifikasi RapidOCR ONNX Engine di Server Linux/Hosting/Windows
 * Buka file ini di browser: https://domain-anda.com/install_ocr.php
 */

header('Content-Type: text/html; charset=utf-8');

// Penanganan penghapusan file installer demi keamanan server
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_file') {
    echo "<!DOCTYPE html><html><head><title>Hapus Installer OCR</title>";
    echo "<style>body{font-family:'Segoe UI',Roboto,Helvetica,sans-serif;padding:30px;background:#f8fafc;} .card{background:#fff;padding:30px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.08);max-width:650px;margin:40px auto;border:1px solid #e2e8f0;text-align:center;} .btn{background:#0284c7;color:#fff;border:none;padding:12px 24px;border-radius:8px;font-size:15px;cursor:pointer;font-weight:600;text-decoration:none;display:inline-block;transition:0.2s;} .btn:hover{background:#0369a1;}</style></head><body>";
    echo "<div class='card'>";
    
    if (@unlink(__FILE__)) {
        echo "<h2 style='color:#16a34a;margin-top:0;'>🗑️ File Berhasil Dihapus!</h2>";
        echo "<p style='color:#475569;font-size:16px;line-height:1.6;'>File <b>install_ocr.php</b> telah berhasil dihapus secara permanen dari server.</p>";
        echo "<p style='color:#64748b;font-size:14px;margin-bottom:25px;'>Server Anda kini aman dari akses luar yang tidak berizin.</p>";
        echo "<a href='index.php' class='btn' style='background:#16a34a;'>Kembali ke Beranda OpenSID</a>";
    } else {
        echo "<h2 style='color:#dc2626;margin-top:0;'>⚠️ Gagal Menghapus File Otomatis</h2>";
        echo "<p style='color:#475569;font-size:15px;'>Izin hak akses file (permission) tidak memungkinkan server menghapus file ini secara otomatis.</p>";
        echo "<p style='color:#64748b;font-size:14px;'>Silakan hapus file <code>install_ocr.php</code> secara manual melalui cPanel / File Manager / FTP Anda demi keamanan.</p>";
        echo "<a href='index.php' class='btn'>Kembali ke OpenSID</a>";
    }
    echo "</div></body></html>";
    exit;
}

echo "<!DOCTYPE html><html><head><title>Status & Instalasi RapidOCR ONNX Engine</title>";
echo "<style>
    body { font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif; padding: 30px; background: #f8fafc; color: #1e293b; }
    .card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); max-width: 780px; margin: 30px auto; border: 1px solid #e2e8f0; }
    h2 { margin-top: 0; color: #0f172a; display: flex; align-items: center; gap: 10px; font-size: 22px; }
    .badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 13px; font-weight: 600; }
    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-danger { background: #fee2e2; color: #b91c1c; }
    .alert-box { padding: 18px 20px; border-radius: 10px; margin: 20px 0; line-height: 1.6; }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
    .btn-group { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 25px; }
    .btn { border: none; padding: 12px 22px; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .btn-primary { background: #0284c7; color: #fff; }
    .btn-primary:hover { background: #0369a1; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
    pre { background: #0f172a; color: #f8fafc; padding: 16px; border-radius: 8px; overflow-x: auto; font-size: 13px; line-height: 1.5; }
    hr { border: none; border-top: 1px solid #e2e8f0; margin: 25px 0; }
</style></head><body>";

echo "<div class='card'>";
echo "<h2>🛠️ Status & Instalasi RapidOCR ONNX Engine</h2>";

if (!function_exists('exec')) {
    echo "<div class='alert-box' style='background:#fee2e2;border:1px solid #fecaca;color:#991b1b;'>";
    echo "<b>❌ Fungsi PHP exec() Tidak Aktif</b><br>Fungsi <code>exec()</code> dinonaktifkan di konfigurasi hosting/server ini. Silakan aktifkan fungsi <code>exec()</code> pada cPanel > Select PHP Version > Options.";
    echo "</div>";
    echo "</div></body></html>";
    exit;
}

// Deteksi Command Python yang tersedia di sistem
$isWin = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
$pyCandidates = $isWin ? ['python', 'python3'] : ['python3', '/usr/bin/python3', '/usr/local/bin/python3', 'python'];

$activePy = null;
$pyVer = null;

foreach ($pyCandidates as $py) {
    $vOut = [];
    $vCode = 1;
    @exec("{$py} --version 2>&1", $vOut, $vCode);
    if ($vCode === 0 && !empty($vOut)) {
        $activePy = $py;
        $pyVer = trim(implode(' ', $vOut));
        break;
    }
}

echo "<div style='display:flex;align-items:center;gap:15px;margin-bottom:15px;font-size:14px;'>";
echo "<span>Fungsi exec(): <span class='badge badge-success'>Aktif ✅</span></span>";
if ($activePy) {
    echo "<span>Python: <span class='badge badge-success'>" . htmlspecialchars($pyVer ?: $activePy) . " ✅</span></span>";
} else {
    echo "<span>Python: <span class='badge badge-danger'>Tidak Ditemukan ❌</span></span>";
}
echo "</div>";

// Script pengecekan modul RapidOCR dan ONNX Runtime
$is_ready = false;
$detectedModule = '';

if ($activePy) {
    $checkPyCmd = "{$activePy} -c \"import importlib.util as u; print('RAPIDOCR_OK' if (u.find_spec('rapidocr_onnxruntime') or u.find_spec('rapidocr')) and u.find_spec('onnxruntime') else 'NO')\" 2>&1";
    $checkOut = [];
    @exec($checkPyCmd, $checkOut, $checkCode);
    $outputStr = trim(implode(' ', (array) $checkOut));
    
    if (strpos($outputStr, 'RAPIDOCR_OK') !== false) {
        $is_ready = true;
    }
}

// Penanganan request instalasi / instal ulang via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] === 'install' || $_POST['action'] === 'reinstall')) {
    echo "<p><b>⏳ Sedang menjalankan proses instalasi paket OCR via Python Pip...</b></p>";
    
    $pipCmd = $isWin 
        ? "{$activePy} -m pip install --upgrade onnxruntime \"rapidocr[onnxruntime]\" rapidocr opencv-python-headless 2>&1"
        : "{$activePy} -m pip install --user --upgrade onnxruntime \"rapidocr[onnxruntime]\" rapidocr opencv-python-headless 2>&1";
        
    $pipOut = [];
    $pipCode = 0;
    @exec($pipCmd, $pipOut, $pipCode);
    
    // Fallback PEP 668 untuk Debian 12 / Ubuntu 24+
    if ($pipCode !== 0 && !$isWin) {
        $pipCmdPep = "{$activePy} -m pip install --user --upgrade --break-system-packages onnxruntime \"rapidocr[onnxruntime]\" rapidocr opencv-python-headless 2>&1";
        @exec($pipCmdPep, $pipOut, $pipCode);
    }
    
    echo "<pre>" . htmlspecialchars(implode("\n", (array) $pipOut)) . "</pre>";
    
    // Verifikasi ulang setelah proses instalasi
    $checkOut2 = [];
    @exec($checkPyCmd, $checkOut2, $checkCode2);
    if (strpos(trim(implode(' ', (array) $checkOut2)), 'RAPIDOCR_OK') !== false) {
        $is_ready = true;
        echo "<div class='alert-box alert-success'><b>🎉 SUKSES! Engine RapidOCR ONNX telah berhasil dipasang dan aktif 100%!</b><br>Fitur Impor Scan KK (OCR) di OpenSID kini siap digunakan.</div>";
    } else {
        echo "<div class='alert-box alert-warning'><b>⚠️ Perhatian:</b> Proses selesai, namun pengecekan modul belum merespons OK. Silakan periksa log di atas.</div>";
    }
}

// TAMPILAN KONDISI 1: JIKA ENGINE SUDAH TERINSTALL
if ($is_ready) {
    echo "<div class='alert-box alert-success'>";
    echo "<h3 style='margin:0 0 8px 0;color:#15803d;display:flex;align-items:center;gap:8px;'>🎉 Engine RapidOCR ONNX Sudah Terpasang & Aktif!</h3>";
    echo "<p style='margin:0;font-size:15px;'>Modul pembaca teks dokumen (RapidOCR & ONNX Runtime) telah siap digunakan di OpenSID. Anda tidak perlu mengunduh atau memasang ulang engine ini lagi.</p>";
    echo "</div>";
    
    echo "<p style='color:#475569;font-size:14px;line-height:1.5;'>Demi keamanan sistem desa Anda dari akses publik yang tidak diinginkan, disarankan untuk segera <b>menghapus berkas installer</b> ini dari server.</p>";
    
    echo "<div class='btn-group'>";
    // Tombol Hapus File Installer
    echo "<form method='POST' onsubmit=\"return confirm('Apakah Anda yakin ingin menghapus file installer install_ocr.php ini dari server sekarang? File akan dihapus permanen demi keamanan.');\">";
    echo "<input type='hidden' name='action' value='delete_file'>";
    echo "<button type='submit' class='btn btn-danger'>🗑️ Hapus File install_ocr.php Sekarang</button>";
    echo "</form>";
    
    // Tombol Kembali ke OpenSID
    echo "<a href='index.php' class='btn btn-primary'>Kembali ke OpenSID</a>";
    
    // Tombol Opsi Sekunder: Install Ulang
    echo "<form method='POST' onsubmit=\"return confirm('Jalankan instal ulang / perbarui paket OCR sekarang?');\">";
    echo "<input type='hidden' name='action' value='reinstall'>";
    echo "<button type='submit' class='btn btn-secondary'>🔄 Perbarui / Install Ulang</button>";
    echo "</form>";
    echo "</div>";

// TAMPILAN KONDISI 2: JIKA ENGINE BELUM TERPASANG
} else {
    echo "<div class='alert-box alert-warning'>";
    echo "<h3 style='margin:0 0 8px 0;color:#b45309;'>⚠️ Engine RapidOCR ONNX Belum Terpasang</h3>";
    echo "<p style='margin:0;font-size:15px;'>Sistem belum mendeteksi pustaka RapidOCR atau ONNX Runtime di lingkungan server ini. Klik tombol di bawah untuk memasangnya secara otomatis.</p>";
    echo "</div>";
    
    echo "<div class='btn-group'>";
    echo "<form method='POST'>";
    echo "<input type='hidden' name='action' value='install'>";
    echo "<button type='submit' class='btn btn-primary'>📥 Mulai Unduh & Pasang Engine RapidOCR</button>";
    echo "</form>";
    echo "<a href='index.php' class='btn btn-secondary'>Kembali ke OpenSID</a>";
    echo "</div>";
}

echo "<hr><p style='color:#94a3b8;font-size:13px;margin:0;'><i>💡 Catatan Keamanan: Setelah instalasi selesai atau engine telah terpasang, selalu hapus file <b>install_ocr.php</b> dari direktori web server Anda.</i></p>";
echo "</div></body></html>";
