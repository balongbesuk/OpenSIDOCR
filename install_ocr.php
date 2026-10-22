<?php
/**
 * Script Pembantu Instalasi RapidOCR ONNX Engine di Server Linux/cPanel
 * Buka file ini di browser: https://domain-anda.com/install_ocr.php
 */

header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><title>Instalasi RapidOCR ONNX Engine</title>";
echo "<style>body{font-family:Segoe UI,sans-serif;padding:30px;background:#f4f6f9;} .card{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);max-width:800px;margin:auto;} pre{background:#272822;color:#f8f8f2;padding:15px;border-radius:5px;overflow-x:auto;} .btn{background:#0284c7;color:#fff;border:none;padding:10px 20px;border-radius:6px;font-size:15px;cursor:pointer;font-weight:bold;text-decoration:none;display:inline-block;} .btn:hover{background:#0369a1;}</style></head><body>";
echo "<div class='card'>";
echo "<h2>🛠️ Instalasi RapidOCR ONNX Engine di Linux Hosting</h2>";

if (!function_exists('exec')) {
    echo "<p style='color:red;'>❌ Fungsi PHP <b>exec()</b> tidak aktif di server ini. Silakan hubungi admin hosting untuk mengaktifkan fungsi exec().</p>";
    echo "</div></body></html>";
    exit;
}

echo "<p>Status fungsi <code>exec()</code>: <b style='color:green;'>AKTIF ✅</b></p>";

// Cek apakah engine sudah aktif di server
$checkPy = 'python3 -c "from rapidocr_onnxruntime import RapidOCR; print(\'OK\')" 2>&1';
@exec($checkPy, $checkOutPy, $checkVarPy);
$is_ready = (trim(implode(' ', (array) $checkOutPy)) === 'OK');

if ($is_ready && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<p style='color:green;font-size:17px;'><b>🎉 Engine RapidOCR & opencv-python-headless sudah terpasang dan aktif di server hosting Anda!</b></p>";
    echo "<p>Fitur Impor Scan KK (OCR) di OpenSID siap digunakan tanpa perlu instalasi ulang.</p>";
    echo "<form method='POST'><button type='submit' name='reinstall' value='1' class='btn' style='background:#64748b;'>Install Ulang / Perbarui Engine</button></form>";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<p>Menjalankan instalasi <code>rapidocr_onnxruntime</code> via Python Pip...</p>";

    $cmd = 'python3 -m pip install --user --upgrade opencv-python-headless rapidocr_onnxruntime 2>&1';
    @exec($cmd, $output, $returnVar);

    echo "<pre>" . htmlspecialchars(implode("\n", (array) $output)) . "</pre>";

    $checkOutPy2 = [];
    @exec($checkPy, $checkOutPy2, $checkVarPy2);

    if (trim(implode(' ', (array) $checkOutPy2)) === 'OK') {
        echo "<p style='color:green;font-size:18px;'><b>🎉 BERHASIL! Engine RapidOCR & opencv-python-headless telah terpasang 100% sempurna di server!</b></p>";
        echo "<p>Fitur Impor Scan KK (OCR) di OpenSID Anda kini siap digunakan!</p>";
    } else {
        echo "<p style='color:orange;'>⚠️ Pengecekan modul: " . htmlspecialchars(implode(' ', (array) $checkOutPy2)) . "</p>";
    }
} else {
    echo "<p>Klik tombol di bawah ini untuk memulai proses instalasi otomatis:</p>";
    echo "<form method='POST'><button type='submit' name='install' value='1' class='btn'>Mulai Unduh & Pasang Engine RapidOCR</button></form>";
}

echo "<hr><p style='color:gray;'><i>Catatan Keamanan: Setelah instalasi berhasil, Anda dapat menghapus file <b>install_ocr.php</b> ini dari server.</i></p>";
echo "</div></body></html>";
