<?php
/**
 * Script Pembantu Instalasi & Verifikasi RapidOCR ONNX Engine di Server Linux/Hosting/Windows
 * Buka file ini di browser: https://domain-anda.com/install_ocr.php
 */

header('Content-Type: text/html; charset=utf-8');

// Penanganan penghapusan file installer demi keamanan server
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_file') {
    echo "<!DOCTYPE html><html><head><title>Hapus Installer OCR</title>";
    echo "<style>body{font-family:'Segoe UI',Roboto,Helvetica,sans-serif;padding:30px;background:#f8fafc;} .card{background:#fff;padding:35px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.08);max-width:550px;margin:50px auto;border:1px solid #e2e8f0;text-align:center;} .btn{background:#16a34a;color:#fff;border:none;padding:12px 24px;border-radius:8px;font-size:15px;cursor:pointer;font-weight:600;text-decoration:none;display:inline-block;transition:0.2s;} .btn:hover{background:#15803d;}</style></head><body>";
    echo "<div class='card'>";
    
    if (@unlink(__FILE__)) {
        echo "<div style='width:64px;height:64px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px auto;'>
            <svg width='32' height='32' viewBox='0 0 24 24' fill='none' stroke='#16a34a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                <path d='M20 6 9 17l-5-5'/>
            </svg>
        </div>";
        echo "<h2 style='color:#16a34a;margin-top:0;'>🗑️ File Berhasil Dihapus!</h2>";
        echo "<p style='color:#475569;font-size:15px;line-height:1.6;'>Berkas <b>install_ocr.php</b> telah berhasil dihapus secara permanen dari server.</p>";
        echo "<p style='color:#64748b;font-size:14px;margin-bottom:25px;'>Server Anda kini aman dari akses publik yang tidak berizin.</p>";
        echo "<a href='index.php' class='btn'>Kembali ke OpenSID</a>";
    } else {
        echo "<h2 style='color:#dc2626;margin-top:0;'>⚠️ Gagal Menghapus File Otomatis</h2>";
        echo "<p style='color:#475569;font-size:15px;'>Izin hak akses file (permission) tidak memungkinkan server menghapus file ini secara otomatis.</p>";
        echo "<p style='color:#64748b;font-size:14px;margin-bottom:25px;'>Silakan hapus berkas <code>install_ocr.php</code> secara manual melalui cPanel / File Manager demi keamanan.</p>";
        echo "<a href='index.php' class='btn' style='background:#0284c7;'>Kembali ke OpenSID</a>";
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
    .alert-danger { background: #fef2f2; border: 1px solid #fee2e2; color: #991b1b; }
    .btn { border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .btn-primary { background: #0284c7; color: #fff; }
    .btn-primary:hover { background: #0369a1; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
    pre { background: #0f172a; color: #f8fafc; padding: 16px; border-radius: 8px; overflow-x: auto; font-size: 13px; line-height: 1.5; }
    hr { border: none; border-top: 1px solid #e2e8f0; margin: 25px 0; }

    /* Modal Popup Styling */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        animation: fadeIn 0.25s ease-out;
    }
    .modal-dialog {
        background: #ffffff;
        max-width: 490px;
        width: 100%;
        border-radius: 16px;
        padding: 32px 26px;
        box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.25);
        text-align: center;
        border: 1px solid #e2e8f0;
        animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .icon-circle {
        width: 68px;
        height: 68px;
        background: #fee2e2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px auto;
    }
    .modal-title {
        font-size: 21px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 10px 0;
    }
    .modal-desc {
        font-size: 14.5px;
        color: #475569;
        line-height: 1.5;
        margin: 0 0 16px 0;
    }
    .modal-alert {
        background: #fef2f2;
        border: 1px solid #fee2e2;
        color: #991b1b;
        border-radius: 8px;
        padding: 13px 15px;
        font-size: 13.5px;
        line-height: 1.5;
        margin-bottom: 24px;
        text-align: left;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
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

if ($activePy) {
    $checkPyCmd = "{$activePy} -c \"import importlib.util as u; print('RAPIDOCR_OK' if (u.find_spec('rapidocr_onnxruntime') or u.find_spec('rapidocr')) and u.find_spec('onnxruntime') else 'NO')\" 2>&1";
    $checkOut = [];
    @exec($checkPyCmd, $checkOut, $checkCode);
    $outputStr = trim(implode(' ', (array) $checkOut));
    
    if (strpos($outputStr, 'RAPIDOCR_OK') !== false) {
        $is_ready = true;
    }
}

// Penanganan request instalasi via POST (hanya jika belum terpasang)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'install') {
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
    } else {
        echo "<div class='alert-box alert-warning'><b>⚠️ Perhatian:</b> Proses selesai, namun pengecekan modul belum merespons OK. Silakan periksa log di atas.</div>";
    }
}

// TAMPILAN KONDISI 1: JIKA ENGINE SUDAH TERINSTALL
if ($is_ready) {
    echo "<div class='alert-box alert-success'>";
    echo "<h3 style='margin:0 0 8px 0;color:#15803d;display:flex;align-items:center;gap:8px;'>🎉 Engine RapidOCR ONNX Sudah Aktif</h3>";
    echo "<p style='margin:0;font-size:15px;'>Modul pembaca teks dokumen telah terpasang dan siap digunakan di OpenSID.</p>";
    echo "</div>";
    
    echo "<div class='alert-box alert-danger' style='margin-top:15px;'>";
    echo "<b>🛡️ Tindakan Keamanan:</b> Berkas <code>install_ocr.php</code> ini harus segera dihapus dari server.";
    echo "</div>";
    
    echo "<div style='margin-top:20px;'>";
    echo "<form method='POST'>";
    echo "<input type='hidden' name='action' value='delete_file'>";
    echo "<button type='submit' class='btn btn-danger' style='font-size:15px;padding:14px 28px;'>🗑️ Hapus File install_ocr.php Sekarang</button>";
    echo "</form>";
    echo "</div>";

    // POPUP MODAL OTOMATIS: TIDAK ADA OPSI LEWATI / NANTI SAJA
    echo "
    <div id='modalBackdrop' class='modal-backdrop'>
        <div class='modal-dialog'>
            <div class='icon-circle'>
                <svg width='34' height='34' viewBox='0 0 24 24' fill='none' stroke='#dc2626' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                    <path d='M3 6h18'/>
                    <path d='M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6'/>
                    <path d='M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2'/>
                    <line x1='10' x2='10' y1='11' y2='17'/>
                    <line x1='14' x2='14' y1='11' y2='17'/>
                </svg>
            </div>
            <h3 class='modal-title'>Engine RapidOCR Sudah Aktif!</h3>
            <p class='modal-desc'>
                Sistem mendeteksi modul RapidOCR & ONNX Runtime telah terpasang dan berfungsi normal di OpenSID.
            </p>
            <div class='modal-alert'>
                🛡️ <b>Peringatan Keamanan Wajib:</b><br>
                Demi mencegah risiko keamanan server desa dari pihak luar, berkas installer <code>install_ocr.php</code> ini harus segera dihapus.
            </div>
            <form method='POST' style='margin:0;'>
                <input type='hidden' name='action' value='delete_file'>
                <button type='submit' class='btn btn-danger' style='width:100%;justify-content:center;padding:15px 24px;font-size:16px;'>
                    🗑️ Hapus File install_ocr.php Sekarang
                </button>
            </form>
        </div>
    </div>
    ";

// TAMPILAN KONDISI 2: JIKA ENGINE BELUM TERPASANG
} else {
    echo "<div class='alert-box alert-warning'>";
    echo "<h3 style='margin:0 0 8px 0;color:#b45309;'>⚠️ Engine RapidOCR ONNX Belum Terpasang</h3>";
    echo "<p style='margin:0;font-size:15px;'>Sistem belum mendeteksi pustaka RapidOCR atau ONNX Runtime di lingkungan server ini. Klik tombol di bawah untuk memasangnya secara otomatis.</p>";
    echo "</div>";
    
    echo "<div style='margin-top:20px;'>";
    echo "<form method='POST'>";
    echo "<input type='hidden' name='action' value='install'>";
    echo "<button type='submit' class='btn btn-primary'>📥 Mulai Unduh & Pasang Engine RapidOCR</button>";
    echo "</form>";
    echo "</div>";
}

echo "<hr><p style='color:#94a3b8;font-size:13px;margin:0;'><i>💡 Catatan Keamanan: Setelah instalasi selesai atau engine telah terpasang, selalu hapus file <b>install_ocr.php</b> dari direktori web server Anda.</i></p>";
echo "</div></body></html>";
