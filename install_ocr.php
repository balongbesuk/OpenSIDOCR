<?php
/**
 * Script Pembantu Instalasi RapidOCR ONNX Engine di Server Linux/cPanel
 * Buka file ini sekali di browser: https://domain-anda.com/install_ocr.php
 */

header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><title>Instalasi RapidOCR ONNX Engine</title>";
echo "<style>body{font-family:Segoe UI,sans-serif;padding:30px;background:#f4f6f9;} .card{background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);max-width:800px;margin:auto;} pre{background:#272822;color:#f8f8f2;padding:15px;border-radius:5px;overflow-x:auto;}</style></head><body>";
echo "<div class='card'>";
echo "<h2>🛠️ Instalasi RapidOCR ONNX Engine di Linux Hosting</h2>";

if (!function_exists('exec')) {
    echo "<p style='color:red;'>❌ Fungsi PHP <b>exec()</b> tidak aktif di server ini. Silakan hubungi admin hosting untuk mengaktifkan fungsi exec().</p>";
    echo "</div></body></html>";
    exit;
}

echo "<p>Status fungsi <code>exec()</code>: <b style='color:green;'>AKTIF ✅</b></p>";
echo "<p>Menjalankan instalasi <code>rapidocr_onnxruntime</code> via Python Pip...</p>";

$cmd = 'python3 -m pip install --user rapidocr_onnxruntime 2>&1';
@exec($cmd, $output, $returnVar);

echo "<pre>" . implode("\n", $output) . "</pre>";

$checkCmd = 'which rapidocr 2>&1';
@exec($checkCmd, $checkOut, $checkVar);

if (!empty($checkOut)) {
    echo "<p style='color:green;font-size:18px;'><b>🎉 BERHASIL! Engine RapidOCR telah terinstall di: " . htmlspecialchars(implode(' ', $checkOut)) . "</b></p>";
    echo "<p>Fitur Impor Scan KK (OCR) di OpenSID siap digunakan 100%!</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Perintah rapidocr belum terdeteksi di PATH. Mencoba alternatif instalasi global...</p>";
    $cmd2 = 'pip3 install --user rapidocr_onnxruntime 2>&1';
    @exec($cmd2, $output2, $returnVar2);
    echo "<pre>" . implode("\n", $output2) . "</pre>";
}

echo "<hr><p style='color:gray;'><i>Catatan Keamanan: Setelah instalasi berhasil, Anda dapat menghapus file <b>install_ocr.php</b> ini.</i></p>";
echo "</div></body></html>";
