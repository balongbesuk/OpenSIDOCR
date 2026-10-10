<?php

namespace App\Libraries;

use Exception;

/**
 * KkScanOcrParser — Library OCR untuk scan/foto Kartu Keluarga
 *
 * Engine: RapidOCR (berbasis model PaddleOCR PP-OCRv4)
 * Paket aktif: 'rapidocr' (pengganti 'rapidocr_onnxruntime' yang sudah deprecated)
 *
 * Catatan soal bahasa Indonesia:
 * - RapidOCR/PaddleOCR menggunakan model 'latin' yang sudah mencakup bahasa Indonesia
 * - TIDAK perlu ind.traineddata (itu khusus Tesseract, engine berbeda)
 * - Model latin PP-OCRv4 sudah sangat akurat untuk teks cetak latin/Indonesia
 */

class KkScanOcrParser
{
    public static function getRapidOcrBinary(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $localWin = FCPATH . 'bin/rapidocr/win64/rapidocr.exe';
            if (file_exists($localWin)) {
                return $localWin;
            }

            return 'rapidocr';
        }

        $localLinux = FCPATH . 'bin/rapidocr/linux64/rapidocr';
        if (file_exists($localLinux)) {
            return $localLinux;
        }

        $home = getenv('HOME') ?: ($_SERVER['HOME'] ?? '');
        if (! empty($home) && file_exists($home . '/.local/bin/rapidocr')) {
            return $home . '/.local/bin/rapidocr';
        }

        $userHomeBin = '/home/' . get_current_user() . '/.local/bin/rapidocr';
        if (file_exists($userHomeBin)) {
            return $userHomeBin;
        }

        // Prioritas: paket baru 'rapidocr' (aktif maintained, PP-OCRv4)
        // Fallback: paket lama 'rapidocr_onnxruntime' (deprecated tapi masih bisa jalan)
        return 'python3 -m rapidocr';
    }

    public static function getEngineInfo(): array
    {
        $bin         = self::getRapidOcrBinary();
        $hasLocalBin = file_exists($bin);

        $isWin        = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
        $pyCandidates = $isWin ? ['python', 'python3'] : ['python3', 'python'];

        $hasNew    = false;
        $hasOld    = false;
        $hasOpencv = false;

        $checkPy = "r=0; o=0; c=0\ntry:\n import rapidocr; r=1\nexcept: pass\ntry:\n import rapidocr_onnxruntime; o=1\nexcept: pass\ntry:\n import cv2; c=1\nexcept: pass\nprint(f'{r},{o},{c}')";

        foreach ($pyCandidates as $py) {
            $cmd  = "{$py} -c " . escapeshellarg($checkPy) . ' 2>&1';
            $out  = [];
            $code = 1;
            @exec($cmd, $out, $code);
            $last  = trim(end($out) ?: '');
            $parts = explode(',', $last);
            if (count($parts) === 3) {
                $hasNew    = ($parts[0] === '1');
                $hasOld    = ($parts[1] === '1');
                $hasOpencv = ($parts[2] === '1');
                break;
            }
        }

        $isAvailable = $hasNew || $hasOld || $hasLocalBin || self::isAvailable();

        return [
            'is_available' => $isAvailable,
            'has_new'      => $hasNew,
            'has_old'      => $hasOld,
            'has_opencv'   => $hasOpencv,
            'is_latest'    => ($hasNew && $hasOpencv),
        ];
    }

    public static function isAvailable(): bool
    {
        $bin = self::getRapidOcrBinary();
        if (file_exists($bin)) {
            return true;
        }

        $isWin = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');

        if ($isWin) {
            @exec('where rapidocr', $out, $code);
            if ($code === 0 && ! empty($out)) {
                return true;
            }

            // Cek paket Python di Windows
            @exec('python -c "import rapidocr" 2>&1', $outPyWin, $codePyWin);
            if ($codePyWin === 0) {
                return true;
            }

            @exec('python -c "import rapidocr_onnxruntime" 2>&1', $outPyOldWin, $codePyOldWin);
            if ($codePyOldWin === 0) {
                return true;
            }

            return false;
        }

        // Cek lokasi .local/bin/rapidocr di Linux cPanel
        $home = getenv('HOME') ?: ($_SERVER['HOME'] ?? '');
        if (! empty($home) && file_exists($home . '/.local/bin/rapidocr')) {
            return true;
        }

        $userHomeBin = '/home/' . get_current_user() . '/.local/bin/rapidocr';
        if (file_exists($userHomeBin)) {
            return true;
        }

        // Cek via modul python3: prioritas paket baru 'rapidocr'
        $outPy = [];
        @exec('python3 -c "import rapidocr" 2>&1', $outPy, $codePy);
        if ($codePy === 0) {
            return true;
        }

        // Fallback: cek paket lama 'rapidocr_onnxruntime' (deprecated)
        $outPyOld = [];
        @exec('python3 -m rapidocr_onnxruntime -h 2>&1', $outPyOld, $codePyOld);
        $outPyStr = implode(' ', $outPyOld);
        if ($codePyOld === 0 || strpos($outPyStr, 'rapidocr') !== false || strpos($outPyStr, 'usage') !== false || strpos($outPyStr, 'options') !== false) {
            return true;
        }

        @exec('which rapidocr 2>&1', $outWhich, $codeWhich);

        return $codeWhich === 0 && ! empty($outWhich);
    }

    /**
     * Ekstrak gambar JPEG dari berkas PDF jika berupa PDF scan
     */
    public static function extractImageFromPdf(string $pdfPath): ?string
    {
        $tmpJpg = sys_get_temp_dir() . '/ocr_pdf_' . md5($pdfPath . @filemtime($pdfPath)) . '.jpg';

        // 1. Coba PyMuPDF via python/python3 jika tersedia (kualitas rendering 300 DPI sangat tinggi)
        $escapedPdf = escapeshellarg($pdfPath);
        $escapedJpg = escapeshellarg($tmpJpg);
        $pyCode     = 'import sys, fitz; doc = fitz.open(sys.argv[1]); page = doc[0]; pix = page.get_pixmap(dpi=300); pix.save(sys.argv[2])';

        $cmdPy3 = "python3 -c " . escapeshellarg($pyCode) . " {$escapedPdf} {$escapedJpg} 2>&1";
        @exec($cmdPy3, $outPy3, $codePy3);
        if ($codePy3 === 0 && file_exists($tmpJpg) && filesize($tmpJpg) > 10000) {
            return $tmpJpg;
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $cmdWin = "python -c " . escapeshellarg($pyCode) . " {$escapedPdf} {$escapedJpg} 2>&1";
            @exec($cmdWin, $outWin, $codeWin);
            if ($codeWin === 0 && file_exists($tmpJpg) && filesize($tmpJpg) > 10000) {
                return $tmpJpg;
            }
        }

        // 2. Fallback ekstraksi stream JPEG terbesar di dalam file PDF
        $content = @file_get_contents($pdfPath);
        if (! $content) {
            return null;
        }

        $offset = 0;
        $images = [];
        while (($start = strpos($content, "\xFF\xD8\xFF", $offset)) !== false) {
            $end = strpos($content, "\xFF\xD9", $start);
            if ($end !== false) {
                $len = ($end + 2) - $start;
                $images[] = substr($content, $start, $len);
                $offset = $end + 2;
            } else {
                break;
            }
        }

        if (! empty($images)) {
            usort($images, static function ($a, $b) {
                return strlen($b) <=> strlen($a);
            });
            $largest = $images[0];
            if (strlen($largest) > 5000) {
                file_put_contents($tmpJpg, $largest);

                return $tmpJpg;
            }
        }

        return null;
    }

    /**
     * Preprocessing gambar sebelum OCR untuk meningkatkan akurasi
     *
     * Pipeline: Grayscale → Denoise → Adaptive Threshold → Deskew
     * Menggunakan OpenCV via Python (sudah terinstal sebagai dependensi RapidOCR)
     *
     * @return string Path ke gambar hasil preprocessing (atau path asli jika gagal)
     */
    public static function preprocessImage(string $imagePath): string
    {
        $preprocessedPath = sys_get_temp_dir() . '/ocr_preprocess_' . md5($imagePath . @filemtime($imagePath)) . '.jpg';

        // Jika sudah pernah diproses, langsung gunakan cache
        if (file_exists($preprocessedPath) && filesize($preprocessedPath) > 1000) {
            return $preprocessedPath;
        }

        $escapedInput  = escapeshellarg($imagePath);
        $escapedOutput = escapeshellarg($preprocessedPath);

        // Python script: Sisipkan site-packages -> Grayscale -> CLAHE (Kontras) -> Mild Sharpen (0.02 detik)
        $pyScript = <<<'PYTHON'
import os, sys, tempfile, glob

patterns = [
    os.path.expanduser('~/.local/lib/python*/site-packages'),
    '/home/*/.local/lib/python*/site-packages',
    '/root/.local/lib/python*/site-packages',
    '/var/www/.local/lib/python*/site-packages',
]
for pat in patterns:
    try:
        for sp in glob.glob(pat):
            if sp not in sys.path:
                sys.path.insert(0, sp)
    except Exception:
        pass

import cv2, numpy as np

try:
    img = cv2.imread(sys.argv[1])
    if img is None:
        sys.exit(1)

    # 1. Grayscale
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

    # 2. CLAHE (Contrast Limited Adaptive Histogram Equalization) — perbaiki kontras lokal tanpa merusak karakter
    clahe = cv2.createCLAHE(clipLimit=2.0, tileGridSize=(8, 8))
    enhanced = clahe.apply(gray)

    # 3. Mild sharpen — pertajam tepi karakter teks
    kernel = np.array([[0, -0.5, 0], [-0.5, 3, -0.5], [0, -0.5, 0]])
    sharpened = cv2.filter2D(enhanced, -1, kernel)

    cv2.imwrite(sys.argv[2], sharpened, [cv2.IMWRITE_JPEG_QUALITY, 95])
    print('OK')
except Exception as e:
    print(f'FAIL:{e}')
    sys.exit(1)
PYTHON;

        $scriptPath = sys_get_temp_dir() . '/ocr_preprocess_script.py';
        file_put_contents($scriptPath, $pyScript);

        $cmd = "python3 " . escapeshellarg($scriptPath) . " {$escapedInput} {$escapedOutput} 2>&1";
        $output = [];
        @exec($cmd, $output, $code);

        // Fallback Windows: coba 'python' jika 'python3' tidak ditemukan
        if ($code !== 0 && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $cmd = "python " . escapeshellarg($scriptPath) . " {$escapedInput} {$escapedOutput} 2>&1";
            @exec($cmd, $output, $code);
        }

        // Jika preprocessing berhasil, gunakan gambar hasil olahan
        if ($code === 0 && file_exists($preprocessedPath) && filesize($preprocessedPath) > 1000) {
            log_message('info', 'OCR Preprocessing berhasil: ' . basename($imagePath));

            return $preprocessedPath;
        }

        // Jika gagal (OpenCV tidak tersedia, dll), gunakan gambar asli — OCR tetap jalan
        log_message('info', 'OCR Preprocessing dilewati, menggunakan gambar asli');

        return $imagePath;
    }

    public static string $lastError = '';

    public static function getLastError(): string
    {
        return self::$lastError;
    }

    /**
     * Jalankan RapidOCR pada gambar dan dapatkan array elemen JSON
     *
     * Prioritas engine:
     * 1. Binary lokal (bin/rapidocr/)
     * 2. Python Runner Script (Auto-detect library, writable HOME, multi-package support)
     */
    public static function executeOcr(string $imagePath): array
    {
        $ext              = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $tempInputWithExt = null;
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'bmp'])) {
            $tempInputWithExt = sys_get_temp_dir() . '/ocr_in_' . md5($imagePath . uniqid('', true)) . '.jpg';
            @copy($imagePath, $tempInputWithExt);
            $targetOcrFile = $tempInputWithExt;
        } else {
            $targetOcrFile = $imagePath;
        }
        $escapedImage = escapeshellarg($targetOcrFile);

        // 1. Coba binary executable lokal jika ada (win64 / linux64)
        $bin = self::getRapidOcrBinary();
        if (file_exists($bin)) {
            $escapedBin = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? '"' . $bin . '"' : escapeshellarg($bin);
            $cmd        = "{$escapedBin} {$escapedImage} 2>&1";
            $outputArray = [];
            @exec($cmd, $outputArray, $returnVar);

            $jsonStr = implode("\n", $outputArray);
            $items   = json_decode($jsonStr, true);
            if (is_array($items) && ! empty($items)) {
                if ($tempInputWithExt && file_exists($tempInputWithExt)) {
                    @unlink($tempInputWithExt);
                }
                return $items;
            }
        }

        // 2. Python Runner Script (Bulletproof untuk cPanel, Docker, VPS, Linux & Windows)
        $pyScript = <<<'PYTHON'
import os, sys, tempfile, glob, json

# 1. Pastikan HOME & RAPIDOCR_HOME mengarah ke direktori yang writable (/tmp)
tmp_dir = tempfile.gettempdir()
try:
    if 'HOME' not in os.environ or not os.access(os.environ.get('HOME', '/'), os.W_OK):
        os.environ['HOME'] = tmp_dir
except Exception:
    os.environ['HOME'] = tmp_dir
os.environ['RAPIDOCR_HOME'] = os.path.join(tmp_dir, '.rapidocr')
os.environ['PYTHONIOENCODING'] = 'utf-8'

# 2. Sisipkan direktori site-packages lokal jika paket diinstall via pip --user
patterns = [
    os.path.expanduser('~/.local/lib/python*/site-packages'),
    '/home/*/.local/lib/python*/site-packages',
    '/root/.local/lib/python*/site-packages',
    '/var/www/.local/lib/python*/site-packages',
]
for pat in patterns:
    try:
        for sp in glob.glob(pat):
            if sp not in sys.path:
                sys.path.insert(0, sp)
    except Exception:
        pass

# 3. Jalankan Engine RapidOCR
try:
    try:
        from rapidocr import RapidOCR
    except ImportError:
        from rapidocr_onnxruntime import RapidOCR

    engine = RapidOCR()
    res = engine(sys.argv[1])
    def to_clean_box(b):
        try:
            if hasattr(b, 'tolist'):
                b = b.tolist()
            # Jika array 3D berlapis [[[x, y], ...]]
            while isinstance(b, (list, tuple)) and len(b) == 1 and isinstance(b[0], (list, tuple)):
                b = b[0]
            # Jika flat 8 angka: [x1, y1, x2, y2, x3, y3, x4, y4]
            if isinstance(b, (list, tuple)) and len(b) == 8 and isinstance(b[0], (int, float)):
                return [[float(b[0]), float(b[1])], [float(b[2]), float(b[3])], [float(b[4]), float(b[5])], [float(b[6]), float(b[7])]]
            # Jika flat 4 angka: [xmin, ymin, xmax, ymax]
            if isinstance(b, (list, tuple)) and len(b) == 4 and isinstance(b[0], (int, float)):
                return [[float(b[0]), float(b[1])], [float(b[2]), float(b[1])], [float(b[2]), float(b[3])], [float(b[0]), float(b[3])]]
            # Jika daftar titik standar: [[x, y], ...]
            if isinstance(b, (list, tuple)):
                pts = []
                for pt in b:
                    if hasattr(pt, 'tolist'):
                        pt = pt.tolist()
                    if isinstance(pt, (list, tuple)) and len(pt) >= 2:
                        pts.append([float(pt[0]), float(pt[1])])
                if len(pts) >= 4:
                    return pts
            return b
        except Exception:
            return b

    def to_clean_score(s):
        try:
            if hasattr(s, 'mean'):
                return float(s.mean())
            if hasattr(s, 'flatten'):
                flat = s.flatten()
                if len(flat) > 0:
                    return float(flat.mean() if hasattr(flat, 'mean') else flat[0])
                return 1.0
            if isinstance(s, (list, tuple)):
                if len(s) > 0:
                    return float(sum(float(x) for x in s) / len(s))
                return 1.0
            return float(s)
        except Exception:
            return 1.0

    def to_clean_text(t):
        try:
            if isinstance(t, (list, tuple)):
                return ' '.join(str(x) for x in t)
            return str(t)
        except Exception:
            return ''

    items = []

    # Pola 1: Format objek resmi RapidOCROutput (versi PP-OCRv4 terbaru di server)
    if hasattr(res, 'boxes') and hasattr(res, 'txts') and res.boxes is not None and res.txts is not None:
        boxes = res.boxes
        txts = res.txts
        scores = getattr(res, 'scores', None)
        for i in range(len(txts)):
            b = to_clean_box(boxes[i])
            t = to_clean_text(txts[i])
            s = to_clean_score(scores[i]) if (scores is not None and i < len(scores)) else 1.0
            items.append({'box': b, 'text': t, 'score': s})
    else:
        # Pola 2 & 3: Format tuple / list (res = (boxes, rec_res) atau res = [[box, text, score], ...])
        raw_0 = None
        raw_1 = None
        if isinstance(res, (tuple, list)):
            if len(res) > 0:
                raw_0 = res[0]
            if len(res) > 1:
                raw_1 = res[1]

        is_old_split = False
        if raw_0 is not None and raw_1 is not None and hasattr(raw_0, '__len__') and hasattr(raw_1, '__len__'):
            try:
                if len(raw_0) > 0 and len(raw_1) == len(raw_0):
                    first_rec = raw_1[0]
                    if isinstance(first_rec, (tuple, list, str)):
                        is_old_split = True
            except Exception:
                is_old_split = False

        if is_old_split:
            for i in range(len(raw_0)):
                b = to_clean_box(raw_0[i])
                rec = raw_1[i]
                if isinstance(rec, (tuple, list)):
                    txt = to_clean_text(rec[0])
                    sc = to_clean_score(rec[1]) if len(rec) > 1 else 1.0
                else:
                    txt = to_clean_text(rec)
                    sc = 1.0
                items.append({'box': b, 'text': txt, 'score': sc})
        else:
            cand_boxes = raw_0 if raw_0 is not None else res
            if cand_boxes is not None:
                for r in cand_boxes:
                    if r is None or not hasattr(r, '__len__') or len(r) < 2:
                        continue
                    box = to_clean_box(r[0])
                    if len(r) >= 3:
                        text = to_clean_text(r[1])
                        score = to_clean_score(r[2])
                    elif len(r) == 2:
                        if isinstance(r[1], (tuple, list)) and len(r[1]) >= 2:
                            text = to_clean_text(r[1][0])
                            score = to_clean_score(r[1][1])
                        else:
                            text = to_clean_text(r[1])
                            score = 1.0
                    else:
                        continue
                    items.append({'box': box, 'text': text, 'score': score})

    # ensure_ascii=True menjamin output murni karakter ASCII (aman di semua console/shell encoding)
    print('__OCR_JSON_START__' + json.dumps(items, ensure_ascii=True) + '__OCR_JSON_END__')
except Exception as e:
    import traceback
    err_tb = traceback.format_exc()
    print('__OCR_ERROR_START__' + str(e) + '\n' + err_tb + '__OCR_ERROR_END__')
    print('__OCR_JSON_START__[]__OCR_JSON_END__')
PYTHON;

        $scriptPath = sys_get_temp_dir() . '/rapidocr_run_' . md5(uniqid((string) mt_rand(), true)) . '.py';
        file_put_contents($scriptPath, $pyScript);

        $isWin        = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
        $pyCandidates = $isWin 
            ? ['python', 'python3'] 
            : ['python3', '/usr/bin/python3', '/usr/local/bin/python3', 'python'];

        $lastCmdOutput = '';
        $lastErrorMsg  = '';

        foreach ($pyCandidates as $pyCmd) {
            $prefix = $isWin ? '' : 'export HOME=/tmp; export PYTHONIOENCODING=utf-8; ';
            $cmd    = "{$prefix}{$pyCmd} " . escapeshellarg($scriptPath) . " {$escapedImage} 2>&1";
            $outputArray = [];
            @exec($cmd, $outputArray, $returnVar);

            $rawOutput     = implode("\n", $outputArray);
            $lastCmdOutput = $rawOutput;

            if (preg_match('/__OCR_ERROR_START__(.*?)__OCR_ERROR_END__/s', $rawOutput, $errMatch)) {
                $lastErrorMsg = trim($errMatch[1]);
            }

            if (preg_match('/__OCR_JSON_START__(.*?)__OCR_JSON_END__/s', $rawOutput, $jsonMatch)) {
                $items = json_decode($jsonMatch[1], true);
                if (is_array($items) && ! empty($items)) {
                    @unlink($scriptPath);
                    if ($tempInputWithExt && file_exists($tempInputWithExt)) {
                        @unlink($tempInputWithExt);
                    }
                    self::$lastError = '';
                    return $items;
                }
            }
        }

        @unlink($scriptPath);
        if ($tempInputWithExt && file_exists($tempInputWithExt)) {
            @unlink($tempInputWithExt);
        }

        $errFinal = $lastErrorMsg ?: substr($lastCmdOutput, 0, 800);
        self::$lastError = $errFinal;
        log_message('error', 'RapidOCR Execution Failed. CMD Output: ' . $errFinal);

        return [];
    }

    /**
     * Putar gambar dengan sudut tertentu (+90, -90, 180)
     */
    public static function rotateImage(string $imagePath, int $angle): string
    {
        if (! function_exists('imagecreatefromjpeg') || ! function_exists('imagerotate')) {
            return $imagePath;
        }

        $img = @imagecreatefromstring(file_get_contents($imagePath));
        if (! $img) {
            return $imagePath;
        }

        $rotated = imagerotate($img, $angle, 0);
        if (! $rotated) {
            imagedestroy($img);

            return $imagePath;
        }

        $rotatedPath = sys_get_temp_dir() . '/ocr_rot_' . md5($imagePath . $angle) . '.jpg';
        imagejpeg($rotated, $rotatedPath, 92);
        imagedestroy($img);
        imagedestroy($rotated);

        return $rotatedPath;
    }

    /**
     * Pastikan orientasi gambar Kartu Keluarga dalam posisi Landscape (Lebar > Tinggi)
     */
    public static function autoEnsureLandscape(string $imagePath): string
    {
        // 1. Koreksi orientasi EXIF jika ada (foto kamera smartphone)
        if (function_exists('exif_read_data')) {
            $exif = @exif_read_data($imagePath);
            if (! empty($exif['Orientation'])) {
                $angle = 0;
                switch ($exif['Orientation']) {
                    case 3:
                        $angle = 180;
                        break;
                    case 6:
                        $angle = -90;
                        break;
                    case 8:
                        $angle = 90;
                        break;
                }
                if ($angle !== 0) {
                    $imagePath = self::rotateImage($imagePath, $angle);
                }
            }
        }

        // 2. Jika tinggi > lebar (Portrait), putar 90 derajat ke Landscape
        $size = @getimagesize($imagePath);
        if ($size && $size[0] < $size[1]) {
            return self::rotateImage($imagePath, 90);
        }

        return $imagePath;
    }

    public static function parseImage(string $imagePath, string $originalFilename = ''): array
    {
        $targetImage = $imagePath;
        $ext         = strtolower(pathinfo($originalFilename ?: $imagePath, PATHINFO_EXTENSION));

        if ($ext === 'pdf') {
            $extracted = self::extractImageFromPdf($imagePath);
            if ($extracted) {
                $targetImage = $extracted;
            }
        }

        // Pastikan posisi gambar Landscape
        $fixedImage = self::autoEnsureLandscape($targetImage);

        // Tahap 1: Jalankan OCR langsung pada gambar asli (Landscape-normalized)
        // Paling cepat (< 2-3 detik) dan paling optimal untuk deep learning RapidOCR
        $items  = self::executeOcr($fixedImage);
        $result = self::parseRapidOcrData($items);

        if (! empty($result['members']) || ! empty($result['header']['no_kk'])) {
            return $result;
        }

        $firstError = self::$lastError;

        // Tahap 2: Fallback Preprocessing CLAHE & Sharpen jika gambar kurang kontras
        $preprocessed = self::preprocessImage($fixedImage);
        if ($preprocessed !== $fixedImage) {
            $itemsPrep  = self::executeOcr($preprocessed);
            $resultPrep = self::parseRapidOcrData($itemsPrep);
            if (! empty($resultPrep['members']) || ! empty($resultPrep['header']['no_kk'])) {
                return $resultPrep;
            }
        }

        // Tahap 3: Fallback Sudut Rotasi (+90, -90, 180) jika dokumen terbalik
        $angles = [90, -90, 180];
        foreach ($angles as $angle) {
            $rotatedPath  = self::rotateImage($fixedImage, $angle);
            $rotatedItems = self::executeOcr($rotatedPath);
            $retryResult  = self::parseRapidOcrData($rotatedItems);

            if (! empty($retryResult['members']) || ! empty($retryResult['header']['no_kk'])) {
                return $retryResult;
            }
        }

        if ($firstError) {
            self::$lastError = $firstError;
        }

        return $result;
    }

    /**
     * Ekstrak koordinat [x, y, maxX, maxY] dari berbagai variasi format box RapidOCR
     * Mendukung: 2D 4-titik [[x,y],...], 3D nested [[[x,y],...]], flat 8 angka, flat 4 angka, dan flat 2 angka [x,y]
     */
    public static function extractBoxCoords($box): array
    {
        if (! is_array($box) || empty($box)) {
            return [0.0, 0.0, 0.0, 0.0];
        }

        // Unwrap jika nested array: [[[x, y], ...]]
        while (isset($box[0]) && is_array($box[0]) && count($box) === 1 && (is_array($box[0][0] ?? null) || is_numeric($box[0][0] ?? null))) {
            $box = $box[0];
        }

        // Format 1: Standar 4 titik [[x1, y1], [x2, y2], [x3, y3], [x4, y4]]
        if (isset($box[0]) && is_array($box[0])) {
            $x    = (float) ($box[0][0] ?? 0);
            $y    = (float) ($box[0][1] ?? 0);
            $maxX = isset($box[1][0]) ? (float) $box[1][0] : $x;
            $maxY = isset($box[2][1]) ? (float) $box[2][1] : $y;

            return [$x, $y, $maxX, $maxY];
        }

        // Format 2: Flat list 8 angka [x1, y1, x2, y2, x3, y3, x4, y4]
        if (count($box) >= 8 && is_numeric($box[0])) {
            $x    = (float) $box[0];
            $y    = (float) $box[1];
            $maxX = (float) $box[2];
            $maxY = (float) $box[5];

            return [$x, $y, $maxX, $maxY];
        }

        // Format 3: Flat list 4 angka [xmin, ymin, xmax, ymax]
        if (count($box) >= 4 && is_numeric($box[0])) {
            $x    = (float) $box[0];
            $y    = (float) $box[1];
            $maxX = (float) $box[2];
            $maxY = (float) $box[3];

            return [$x, $y, $maxX, $maxY];
        }

        // Format 4: Flat list 2 angka [x, y] (Format titik koordinat tunggal)
        if (count($box) >= 2 && is_numeric($box[0])) {
            $x = (float) $box[0];
            $y = (float) ($box[1] ?? 0);

            return [$x, $y, $x, $y];
        }

        return [0.0, 0.0, 0.0, 0.0];
    }

    public static function parseRapidOcrData(array $items): array
    {
        $header = [
            'no_kk'           => '',
            'kepala_keluarga' => '',
            'alamat'          => '',
            'rt'              => '001',
            'rw'              => '001',
            'desa'            => '',
            'kecamatan'       => '',
            'kabupaten'       => '',
            'provinsi'        => '',
            'tgl_cetak'       => date('Y-m-d'),
        ];

        if (empty($items)) {
            return [
                'header'   => $header,
                'members'  => [],
                'raw_text' => '',
            ];
        }

        // Hitung estimasi tinggi gambar dari Y max untuk menentukan threshold Y yang proporsional
        $maxY = 720;
        foreach ($items as $it) {
            [$bx, $by, $bMaxX, $bMaxY] = self::extractBoxCoords($it['box'] ?? null);
            if ($by > $maxY) {
                $maxY = $by;
            }
            if ($bMaxY > $maxY) {
                $maxY = $bMaxY;
            }
        }
        $yThreshold = max(6, (int) round(8 * ($maxY / 720)));

        // Kelompokkan item menjadi baris-baris horizontal
        $lines = [];
        foreach ($items as $item) {
            $text = trim($item['text'] ?? '');
            if ($text === '') {
                continue;
            }
            [$x, $y, $maxX, $curMaxY] = self::extractBoxCoords($item['box'] ?? null);

            $itemHasNik = (bool) preg_match('/\b\d{16}\b/', $text);

            $foundLine = false;
            foreach ($lines as &$line) {
                if (abs($line['y'] - $y) <= $yThreshold) {
                    $lineHasNik = false;
                    foreach ($line['items'] as $li) {
                        if (preg_match('/\b\d{16}\b/', $li['text'])) {
                            $lineHasNik = true;
                            break;
                        }
                    }

                    if ($itemHasNik && $lineHasNik) {
                        continue;
                    }

                    $line['items'][] = ['x' => $x, 'text' => $text];
                    $foundLine       = true;

                    break;
                }
            }
            if (! $foundLine) {
                $lines[] = [
                    'y'     => $y,
                    'items' => [['x' => $x, 'text' => $text]],
                ];
            }
        }

        // Fallback jika pengelompokan baris menghasilkan <= 2 baris (misal koordinat Y seragam/gagal)
        if (count($lines) <= 2 && count($items) > 10) {
            $fallbackLines = [];
            $curLine       = [];
            foreach ($items as $item) {
                $text = trim($item['text'] ?? '');
                if ($text === '') {
                    continue;
                }
                [$x, $y, $maxX, $maxY] = self::extractBoxCoords($item['box'] ?? null);

                // Baris baru jika penomoran tabel 1..10 atau kata kunci field formulir
                $isNewRow = (bool) preg_match('/^\b(1|2|3|4|5|6|7|8|9|10)\b$/', $text)
                    || (bool) preg_match('/^(?:Nama\s*Kepala|Alamat|RT\s*[\/\-]?\s*RW|Desa|Kecamatan|Kabupaten|Kode\s*Pos|No\b)/i', $text);

                if ($isNewRow && ! empty($curLine)) {
                    $fallbackLines[] = ['y' => 0, 'items' => $curLine];
                    $curLine         = [];
                }
                $curLine[] = ['x' => $x, 'text' => $text];
            }
            if (! empty($curLine)) {
                $fallbackLines[] = ['y' => 0, 'items' => $curLine];
            }
            if (count($fallbackLines) > count($lines)) {
                $lines = $fallbackLines;
            }
        }

        // 1. Urutkan baris dari ATAS ke BAWAH (posisi Y) — Sangat krusial agar urutan dokumen teratur
        usort($lines, static function ($a, $b) {
            return $a['y'] <=> $b['y'];
        });

        // 2. Urutkan item dalam tiap baris dari KIRI ke KANAN (posisi X)
        $rawLineTexts = [];
        foreach ($lines as &$line) {
            usort($line['items'], static function ($a, $b) {
                return $a['x'] <=> $b['x'];
            });
            $line['full_text'] = implode(' ', array_column($line['items'], 'text'));
            $rawLineTexts[]    = $line['full_text'];
        }
        unset($line); // Hapus referensi dangling PHP

        // 3. Ekstraksi Nomor KK Terlebih Dahulu
        // Prioritas 1: Baris atas dokumen (6 baris pertama)
        foreach (array_slice($rawLineTexts, 0, 8) as $l) {
            if (preg_match('/(?:KARTU\s*KELUARGA|\bNo\b|\bNo\.?)\s*[\.\:\=\s]*(\d{16})/iu', $l, $m)) {
                $header['no_kk'] = $m[1];
                break;
            }
            if (empty($header['no_kk']) && preg_match('/\b(\d{16})\b/', $l, $m)) {
                $header['no_kk'] = $m[1];
                break;
            }
        }

        // Prioritas 2: Cari langsung di kotak item OCR yang berada di 300px teratas
        if (empty($header['no_kk'])) {
            foreach ($items as $it) {
                $t = trim($it['text'] ?? '');
                [$bx, $by, $bmx, $bmy] = self::extractBoxCoords($it['box'] ?? null);
                if ($by < 350) {
                    if (preg_match('/(?:KARTU\s*KELUARGA|\bNo\b|\bNo\.?)\s*[\.\:\=\s]*(\d{16})/i', $t, $m)) {
                        $header['no_kk'] = $m[1];
                        break;
                    }
                    if (preg_match('/\b(\d{16})\b/', $t, $m)) {
                        $header['no_kk'] = $m[1];
                        break;
                    }
                }
            }
        }

        // Prioritas 3: Cari 16-digit angka pertama yang diawali kode provinsi standar (11-99)
        if (empty($header['no_kk'])) {
            foreach ($rawLineTexts as $l) {
                $up = strtoupper($l);
                if (strpos($up, 'TANDA TANGAN') !== false || strpos($up, 'KEPALA DINAS') !== false || strpos($up, 'NIP') !== false) {
                    break;
                }
                if (preg_match('/\b([1-9]\d{15})\b/', $l, $m)) {
                    $header['no_kk'] = $m[1];
                    break;
                }
            }
        }

        // 4. Ekstraksi data Header KK lainnya
        foreach ($rawLineTexts as $line) {
            $upperLine = strtoupper($line);
            if (strpos($upperLine, 'TANDA TANGAN') !== false || strpos($upperLine, 'NIP') !== false || strpos($upperLine, 'BSRE') !== false) {
                continue;
            }

            if (preg_match('/Nama\s*[\/\.\-]?\s*Kepala\s*Keluarga\s*[:=：＝\s]*(.+)/iu', $line, $m)) {
                $rawNama                   = preg_replace('/(Kecamatan|Alamat|RT|RW|Kabupaten|Desa).*/iu', '', $m[1]);
                $header['kepala_keluarga'] = self::splitConcatenatedName(strtoupper(trim(preg_replace('/[^a-zA-Z\s\,\.\']/u', '', $rawNama))));
            }
            if (preg_match('/Alamat\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawAlamat        = preg_replace('/(Kabupaten|Kecamatan|Desa|Kode\s+Pos|RT|RW).*/iu', '', $m[1]);
                $header['alamat'] = self::splitConcatenatedName(strtoupper(trim(preg_replace('/[^a-zA-Z0-9\s\.\,\/]/u', '', $rawAlamat))));
            }
            if (preg_match('/RT\s*[\/\.\-]?\s*RW\s*[:=：＝\s]*(\d+)\s*[\/\.\-]\s*(\d+)/u', $line, $m)) {
                $header['rt'] = sprintf('%03d', (int) $m[1]);
                $header['rw'] = sprintf('%03d', (int) $m[2]);
            }
            if (preg_match('/Desa\s*[\/\.\-]?\s*Kelurahan\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawDesa        = preg_replace('/(Provinsi|Kecamatan|Kabupaten|Kode).*/iu', '', $m[1]);
                $header['desa'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $rawDesa)));
            }
            if (preg_match('/Kecamatan\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawKec              = preg_replace('/(Kabupaten|Provinsi|Desa|Kode).*/iu', '', $m[1]);
                $header['kecamatan'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $rawKec)));
            }
            if (preg_match('/Kabupaten\s*[\/\.\-]?\s*Kota\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $rawKab              = preg_replace('/(Provinsi|Kode\s+Pos).*/iu', '', $m[1]);
                $header['kabupaten'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $rawKab)));
            }
            if (preg_match('/Provinsi\s*[:=：＝\s]*(.+)/u', $line, $m)) {
                $header['provinsi'] = strtoupper(trim(preg_replace('/[^a-zA-Z\s]/u', '', $m[1])));
            }
            if (preg_match('/Dikeluarkan\s+Tanggal\s*[:=：＝\s]*(\d{2}[\-\/]\d{2}[\-\/]\d{4})/iu', $line, $m)) {
                $header['tgl_cetak'] = self::formatDate($m[1]);
            }
        }

        // Ekstraksi Data Anggota Keluarga (Tabel 1 & Tabel 2)
        $members = self::extractMembersFromRapidOcr($rawLineTexts, $header['no_kk']);

        // Jika kepala keluarga belum terisi tapi anggota ditemukan, gunakan nama anggota pertama
        if (empty($header['kepala_keluarga']) && ! empty($members[0]['nama'])) {
            $header['kepala_keluarga'] = $members[0]['nama'];
        }

        if (empty($header['no_kk']) || empty($members)) {
            $sampleLines = implode(' // ', array_slice($rawLineTexts, 0, 3));
            if (strlen($sampleLines) > 60) {
                $sampleLines = substr($sampleLines, 0, 57) . '...';
            }
            self::$lastError = 'Hasil OCR: ' . count($items) . ' blok teks (' . count($rawLineTexts) . ' baris, L0-2: ' . $sampleLines . '). No KK: ' . ($header['no_kk'] ?: 'KOSONG') . ', Anggota: ' . count($members) . ' orang.';
            log_message('info', self::$lastError);
        }

        return [
            'header'   => $header,
            'members'  => $members,
            'raw_text' => implode("\n", $rawLineTexts),
        ];
    }

    private static function extractMembersFromRapidOcr(array $lines, string $headerNoKk = ''): array
    {
        $table1Rows = [];
        $table2Rows = [];

        $inTable2Section = false;

        foreach ($lines as $line) {
            $upperLine = strtoupper(trim($line));

            // Deteksi batas Tabel 2 (Status Perkawinan & Nama Orang Tua)
            $upperNoSpace = preg_replace('/\s+/', '', $upperLine);
            if (strpos($upperNoSpace, 'DOKUMENIMIGRASI') !== false || strpos($upperNoSpace, 'NAMAORANGTUA') !== false || strpos($upperNoSpace, 'STATUSPERKAWINAN') !== false || strpos($upperNoSpace, 'STATUSHUBUNGAN') !== false) {
                $inTable2Section = true;
                continue;
            }

            if (strpos($upperLine, 'DIKELUARKAN') !== false || strpos($upperLine, 'KEPALA DINAS') !== false || strpos($upperLine, 'KEPALADINAS') !== false || strpos($upperLine, 'TANDA TANGAN') !== false) {
                $inTable2Section = false;
                continue;
            }

            if (strpos($upperLine, 'NIP') !== false || strpos($upperLine, 'BSRE') !== false) {
                continue;
            }

            // Ekstrak baris Tabel 1: Setiap baris yang memiliki NIK 16 digit yang BUKAN No KK
            $nik = '';
            $nama = '';

            // Prioritas 1: NIK 16 digit murni
            if (preg_match('/\b(\d{16})\b/', $line, $mNik)) {
                $candNik = $mNik[1];
                if (empty($headerNoKk) || $candNik !== $headerNoKk) {
                    $nik = $candNik;
                    $posNik = strpos($line, $nik);
                    $beforeNik = trim(substr($line, 0, $posNik));
                    $namaRaw = preg_replace('/^\d+[\s\|\.\/]+/', '', $beforeNik);
                    $nama = self::splitConcatenatedName(strtoupper(trim(preg_replace('/[^a-zA-Z\s\,\.\']/u', '', $namaRaw))));
                }
            }

            // Prioritas 2: Fuzzy Digit per-token jika ada 16-digit angka tertukar huruf (O->0, I->1, dll)
            if (empty($nik)) {
                $tokens = preg_split('/\s+/', $line);
                foreach ($tokens as $tok) {
                    $cleanedTok = self::cleanOcrDigitString($tok);
                    if (strlen($cleanedTok) === 16) {
                        if (! empty($headerNoKk) && $cleanedTok === $headerNoKk) {
                            continue;
                        }
                        $nik = $cleanedTok;
                        $posTok = strpos($line, $tok);
                        $beforeTok = trim(substr($line, 0, $posTok));
                        $namaRaw = preg_replace('/^\d+[\s\|\.\/]+/', '', $beforeTok);
                        $nama = self::splitConcatenatedName(strtoupper(trim(preg_replace('/[^a-zA-Z\s\,\.\']/u', '', $namaRaw))));
                        break;
                    }
                }
            }

            if (! empty($nik)) {
                $tglLahir = '';
                if (preg_match('/(\d{2}[\-\/]\d{2}[\-\/]\d{4})/', $line, $dateMatch)) {
                    $tglLahir = self::formatDate($dateMatch[1]);
                }

                $tempatLahir = '';
                if (preg_match('/(JOMBANG|SRAGEN|SURABAYA|MALANG|KEDIRI|BLITAR|MOJOKERTO|NGAWI|MAGETAN|MADIUN|PONOROGO|TULUNGAGUNG|TRENGGALEK|SIDOARJO|GRESIK|LAMONGAN|TUBAN|BOJONEGORO|NGANJUK|PASURUAN|PROBOLINGGO|LUMAJANG|BONDOWOSO|SITUBONDO|JEMBER|BANYUWANGI|BANGKALAN|SAMPANG|PAMEKASAN|SUMENEP|JAKARTA|BANDUNG|SEMARANG|YOGYAKARTA)/i', $line, $tmMatch)) {
                    $tempatLahir = strtoupper($tmMatch[1]);
                }

                $pendidikan = 'SLTA/SEDERAJAT';
                if (preg_match('/STRATA\s*(?:III|3)\b/i', $upperLine) || preg_match('/\bS3\b/i', $upperLine)) {
                    $pendidikan = 'STRATA III';
                } elseif (preg_match('/STRATA\s*(?:II|2)\b/i', $upperLine) || preg_match('/\bS2\b/i', $upperLine)) {
                    $pendidikan = 'STRATA II';
                } elseif (strpos($upperLine, 'DIPLOMA IV') !== false || preg_match('/STRATA\s*(?:I|1)\b/i', $upperLine) || preg_match('/\bS1\b/i', $upperLine) || strpos($upperLine, 'S.PD') !== false) {
                    $pendidikan = 'DIPLOMA IV/ STRATA I';
                } elseif (strpos($upperLine, 'DIPLOMA III') !== false || strpos($upperLine, 'AKADEMI') !== false || strpos($upperLine, 'S.MUDA') !== false || preg_match('/\bD3\b/i', $upperLine)) {
                    $pendidikan = 'AKADEMI/ DIPLOMA III/S. MUDA';
                } elseif (preg_match('/DIPLOMA\s*(?:I\s*[\/\-]\s*II|1\s*[\/\-]\s*2)\b/i', $upperLine) || strpos($upperLine, 'DIPLOMA I/II') !== false || strpos($upperLine, 'DIPLOMA I / II') !== false) {
                    $pendidikan = 'DIPLOMA I/II';
                } elseif (preg_match('/(?:BELUM|TIDAK|BLM)\s*TAMAT\s*SD/i', $upperLine) || (strpos($upperLine, 'BELUM') !== false && strpos($upperLine, 'SD') !== false)) {
                    $pendidikan = 'BELUM TAMAT SD/SEDERAJAT';
                } elseif (preg_match('/TAMAT\s*SD/i', $upperLine) || preg_match('/\bSD[\/\s\.\,vV\-]*SEDERA/i', $upperLine) || strpos($upperLine, 'TAMAT SD') !== false || strpos($upperLine, 'SD/SEDERAJAT') !== false || strpos($upperLine, 'SDVSEDERAIAT') !== false) {
                    $pendidikan = 'TAMAT SD/SEDERAJAT';
                } elseif (preg_match('/(?:TIDAK|BELUM|BLM)\s*(?:PERNAH\s*)?SEKOLAH/i', $upperLine) || (strpos($upperLine, 'TIDAK') !== false && strpos($upperLine, 'SEKOLAH') !== false)) {
                    $pendidikan = 'TIDAK/BLM SEKOLAH';
                } elseif (preg_match('/\b(SLTP|SMP|MTS)\b/i', $upperLine) || preg_match('/SLTP[\/\s\.\,vV\-]*SEDERA/i', $upperLine)) {
                    $pendidikan = 'SLTP/SEDERAJAT';
                } elseif (preg_match('/\b(SLTA|SMA|SMK|MA)\b/i', $upperLine) || preg_match('/SLTA[\/\s\.\,vV\-]*SEDERA/i', $upperLine) || strpos($upperLine, 'SLTASEDERAJAT') !== false) {
                    $pendidikan = 'SLTA/SEDERAJAT';
                }

                $pekerjaan = 'BELUM/TIDAK BEKERJA';
                if (preg_match('/BURUH\s*(?:TANI|PERKEBUNAN)/i', $upperLine)) {
                    $pekerjaan = 'BURUH TANI/PERKEBUNAN';
                } elseif (preg_match('/BURUH\s*NELAYAN/i', $upperLine)) {
                    $pekerjaan = 'BURUH NELAYAN/PERIKANAN';
                } elseif (preg_match('/BURUH\s*PETERNAKAN/i', $upperLine)) {
                    $pekerjaan = 'BURUH PETERNAKAN';
                } elseif (preg_match('/BURUH\s*HARIAN\s*LEPAS/i', $upperLine) || preg_match('/BURUHHARIAN\s*LEPAS/i', $upperLine) || preg_match('/\bBURUH\b/i', $upperLine)) {
                    $pekerjaan = 'BURUH HARIAN LEPAS';
                } elseif (preg_match('/MENGURUS\s*RUMAH\s*TANGGA/i', $upperLine) || strpos($upperLine, 'MENGURUS') !== false || strpos($upperLine, 'RUMAH TANGGA') !== false) {
                    $pekerjaan = 'MENGURUS RUMAH TANGGA';
                } elseif (preg_match('/\b(GURU|DOSEN)\b/i', $upperLine)) {
                    $pekerjaan = 'GURU';
                } elseif (strpos($upperLine, 'PELAJAR') !== false || strpos($upperLine, 'MAHASISWA') !== false) {
                    $pekerjaan = 'PELAJAR/MAHASISWA';
                } elseif (preg_match('/\b(PNS|ASN|PEGAWAI NEGERI)\b/i', $upperLine)) {
                    $pekerjaan = 'PEGAWAI NEGERI SIPIL (PNS)';
                } elseif (preg_match('/\b(TNI|TENTARA)\b/i', $upperLine)) {
                    $pekerjaan = 'TENTARA NASIONAL INDONESIA (TNI)';
                } elseif (preg_match('/\b(POLRI|POLISI)\b/i', $upperLine)) {
                    $pekerjaan = 'KEPOLISIAN RI (POLRI)';
                } elseif (strpos($upperLine, 'PENSIUNAN') !== false || strpos($upperLine, 'PENSIUN') !== false) {
                    $pekerjaan = 'PENSIUNAN';
                } elseif (strpos($upperLine, 'PERANGKAT DESA') !== false) {
                    $pekerjaan = 'PERANGKAT DESA';
                } elseif (strpos($upperLine, 'KEPALA DESA') !== false) {
                    $pekerjaan = 'KEPALA DESA';
                } elseif (strpos($upperLine, 'WIRASWASTA') !== false || strpos($upperLine, 'WIRA SWASTA') !== false) {
                    $pekerjaan = 'WIRASWASTA';
                } elseif (strpos($upperLine, 'KARYAWAN BUMN') !== false) {
                    $pekerjaan = 'KARYAWAN BUMN';
                } elseif (strpos($upperLine, 'KARYAWAN BUMD') !== false) {
                    $pekerjaan = 'KARYAWAN BUMD';
                } elseif (strpos($upperLine, 'KARYAWAN') !== false || (strpos($upperLine, 'SWASTA') !== false && strpos($upperLine, 'WIRA') === false)) {
                    $pekerjaan = 'KARYAWAN SWASTA';
                } elseif (preg_match('/\b(PETANI|PEKEBUN)\b/i', $upperLine)) {
                    $pekerjaan = 'PETANI/PEKEBUN';
                } elseif (strpos($upperLine, 'PETERNAK') !== false) {
                    $pekerjaan = 'PETERNAK';
                } elseif (strpos($upperLine, 'NELAYAN') !== false) {
                    $pekerjaan = 'NELAYAN/PERIKANAN';
                } elseif (strpos($upperLine, 'PEDAGANG') !== false || strpos($upperLine, 'PERDAGANGAN') !== false) {
                    $pekerjaan = 'PERDAGANGAN';
                } elseif (preg_match('/\b(SOPIR|SUPIR|DRIVER)\b/i', $upperLine)) {
                    $pekerjaan = 'SOPIR';
                } elseif (preg_match('/\bTUKANG\b/i', $upperLine)) {
                    $pekerjaan = 'TUKANG BATU';
                } elseif ((strpos($upperLine, 'BELUM') !== false && strpos($upperLine, 'BEKERJA') !== false) || strpos($upperLine, 'TIDAK BEKERJA') !== false || strpos($upperLine, 'BELUMTIDAK') !== false) {
                    $pekerjaan = 'BELUM/TIDAK BEKERJA';
                }

                $sex = (strpos($upperLine, 'PEREMPUAN') !== false) ? 'PEREMPUAN' : 'LAKI-LAKI';

                $table1Rows[] = [
                    'nik'          => $nik,
                    'nama'         => $nama,
                    'sex'          => $sex,
                    'tempatlahir'  => $tempatLahir,
                    'tanggallahir' => $tglLahir,
                    'agama'        => 'ISLAM',
                    'pendidikan'   => $pendidikan,
                    'pekerjaan'    => $pekerjaan,
                ];
            }

            // Deteksi baris Tabel 2 (Status Hubungan & Nama Orang Tua: Ayah/Ibu)
            if ($inTable2Section && preg_match('/(\bKAW[I|N]\b|\bBELUMKAWIN\b|KEPALA\s*KELUARGA|\bISTRI\b|\bANAK\b|\bWNI\b)/i', $upperLine)) {
                if (strpos($upperLine, 'PERKAWINAN') !== false || strpos($upperLine, 'KEWARGANEGARAAN') !== false || (strpos($upperLine, 'AYAH') !== false && strpos($upperLine, 'IBU') !== false) || strpos($upperLine, 'PASPOR') !== false || strpos($upperLine, 'KITAS') !== false || strpos($upperLine, 'KITAP') !== false || strpos($upperLine, 'IMIGRASI') !== false) {
                    continue;
                }

                $tglKawin = '';
                if (preg_match('/(\d{2}[\-\/]\d{2}[\-\/]\d{4})/', $line, $dateMatch)) {
                    $tglKawin = self::formatDate($dateMatch[1]);
                }

                $namaAyah = '-';
                $namaIbu  = '-';

                // Jika baris memuat status Kewarganegaraan WNI / WNA, ambil nama di belakang WNI/WNA
                if (preg_match('/\b(?:WNI|WNA)\b\s+(.+)$/i', trim($line), $wniMatch)) {
                    $parentsStr = trim($wniMatch[1]);
                    $words      = preg_split('/\s+/', $parentsStr);
                    $cleanWords = [];
                    foreach ($words as $w) {
                        $wClean = trim(preg_replace('/[^a-zA-Z\s\,\.\']/', '', $w));
                        if (strlen($wClean) >= 2) {
                            $cleanWords[] = strtoupper($wClean);
                        }
                    }
                    if (count($cleanWords) === 3) {
                        if (in_array($cleanWords[1], ['NING', 'SITI', 'SRI', 'HJ', 'DRA', 'ST', 'IR', 'AMAH'])) {
                            $namaAyah = $cleanWords[0];
                            $namaIbu  = $cleanWords[1] . ' ' . $cleanWords[2];
                        } else {
                            $namaIbu  = array_pop($cleanWords);
                            $namaAyah = implode(' ', $cleanWords);
                        }
                    } elseif (count($cleanWords) >= 2) {
                        $namaIbu  = array_pop($cleanWords);
                        $namaAyah = implode(' ', $cleanWords);
                    } elseif (count($cleanWords) === 1) {
                        $namaAyah = $cleanWords[0];
                    }
                } else {
                    $cleanWords = [];
                    $words      = preg_split('/\s+/', trim($line));
                    foreach ($words as $w) {
                        $wClean = trim(preg_replace('/[^a-zA-Z\s\,\.\']/', '', $w));
                        if (strlen($wClean) >= 2 && ! in_array(strtoupper($wClean), ['KAWIN', 'TERCATAT', 'KAWINTERCATAT', 'BELUMKAWIN', 'BELUM', 'CERAI', 'HIDUP', 'MATI', 'KEPALAKELUARGA', 'KEPALA', 'KELUARGA', 'ISTRI', 'ANAK', 'WNI', 'WNA', 'NO', 'PASPOR', 'KITAS', 'KITAP', 'STATUS', 'PERKAWINAN', 'DALAM', 'KEWARGANEGARAAN', 'IMIGRASI', 'NAMA', 'ORANG', 'TUA', 'AYAH', 'IBU'])) {
                            $cleanWords[] = strtoupper($wClean);
                        }
                    }
                    if (count($cleanWords) === 3) {
                        if (in_array($cleanWords[1], ['NING', 'SITI', 'SRI', 'HJ', 'DRA', 'ST', 'IR', 'AMAH'])) {
                            $namaAyah = $cleanWords[0];
                            $namaIbu  = $cleanWords[1] . ' ' . $cleanWords[2];
                        } else {
                            $namaIbu  = array_pop($cleanWords);
                            $namaAyah = implode(' ', $cleanWords);
                        }
                    } elseif (count($cleanWords) >= 2) {
                        $namaIbu  = array_pop($cleanWords);
                        $namaAyah = implode(' ', $cleanWords);
                    } elseif (count($cleanWords) === 1) {
                        $namaAyah = $cleanWords[0];
                    }
                }

                $statusKawin = '';
                $upperCleanLine = strtoupper(preg_replace('/\s+/', ' ', $line));
                if (strpos($upperCleanLine, 'CERAI BELUM TERCATAT') !== false || strpos($upperCleanLine, 'CERAIBELUMTERCATAT') !== false) {
                    $statusKawin = 'CERAI BELUM TERCATAT';
                } elseif (strpos($upperCleanLine, 'CERAI TERCATAT') !== false || strpos($upperCleanLine, 'CERAITERCATAT') !== false) {
                    $statusKawin = 'CERAI TERCATAT';
                } elseif (strpos($upperCleanLine, 'CERAI HIDUP') !== false || strpos($upperCleanLine, 'CERAIHIDUP') !== false) {
                    $statusKawin = 'CERAI HIDUP';
                } elseif (strpos($upperCleanLine, 'CERAI MATI') !== false || strpos($upperCleanLine, 'CERAIMATI') !== false) {
                    $statusKawin = 'CERAI MATI';
                } elseif (strpos($upperCleanLine, 'KAWIN BELUM TERCATAT') !== false || strpos($upperCleanLine, 'KAWINBELUMTERCATAT') !== false) {
                    $statusKawin = 'KAWIN BELUM TERCATAT';
                } elseif (strpos($upperCleanLine, 'KAWIN TERCATAT') !== false || strpos($upperCleanLine, 'KAWINTERCATAT') !== false) {
                    $statusKawin = 'KAWIN TERCATAT';
                } elseif (strpos($upperCleanLine, 'BELUM KAWIN') !== false || strpos($upperCleanLine, 'BELUMKAWIN') !== false) {
                    $statusKawin = 'BELUM KAWIN';
                } elseif (preg_match('/\bKAWIN\b/', $upperCleanLine)) {
                    $statusKawin = 'KAWIN';
                }

                if ($namaAyah !== '-' || $namaIbu !== '-' || ! empty($statusKawin)) {
                    $table2Rows[] = [
                        'status_kawin'      => $statusKawin,
                        'nama_ayah'         => self::splitConcatenatedName($namaAyah),
                        'nama_ibu'          => self::splitConcatenatedName($namaIbu),
                        'tanggalperkawinan' => $tglKawin,
                    ];
                }
            }
        }

        // Penggabungan data Tabel 1 & Tabel 2 secara urut baris dengan hirarki SHDK baku KK Indonesia
        $members = [];
        foreach ($table1Rows as $idx => $t1) {
            $t2 = $table2Rows[$idx] ?? [];

            if ($idx === 0) {
                $finalHub   = 'KEPALA KELUARGA';
                $finalKawin = ! empty($t2['status_kawin']) ? $t2['status_kawin'] : 'KAWIN';
            } elseif ($idx === 1 && $t1['sex'] === 'PEREMPUAN') {
                $finalHub   = 'ISTRI';
                $finalKawin = ! empty($t2['status_kawin']) ? $t2['status_kawin'] : 'KAWIN';
            } else {
                $finalHub   = 'ANAK';
                $finalKawin = ! empty($t2['status_kawin']) ? $t2['status_kawin'] : 'BELUM KAWIN';
            }

            $members[] = [
                'no'                => $idx + 1,
                'nama'              => $t1['nama'] ?: 'ANGGOTA ' . ($idx + 1),
                'nik'               => $t1['nik'],
                'sex'               => $t1['sex'],
                'tempatlahir'       => $t1['tempatlahir'],
                'tanggallahir'      => $t1['tanggallahir'],
                'agama'             => $t1['agama'],
                'pendidikan'        => $t1['pendidikan'],
                'pekerjaan'         => $t1['pekerjaan'],
                'golongan_darah'    => 'TIDAK TAHU',
                'status_kawin'      => $finalKawin,
                'tanggalperkawinan' => $t2['tanggalperkawinan'] ?? '',
                'hubungan'          => $finalHub,
                'kewarganegaraan'   => 'WNI',
                'nama_ayah'         => $t2['nama_ayah'] ?? '-',
                'nama_ibu'          => $t2['nama_ibu'] ?? '-',
            ];
        }

        return $members;
    }

    public static function splitConcatenatedName(string $name): string
    {
        $name = trim($name);
        if ($name === '' || $name === '-') {
            return $name;
        }

        // Sisipkan spasi setelah titik jika belum ada spasi (misal: MOH.AJIR -> MOH. AJIR, ST.MAIMUNAH -> ST. MAIMUNAH)
        $name = preg_replace('/([A-Z0-9]{2,})\.([A-Z0-9])/i', '$1. $2', $name);

        $tokens = [
            'MUCHAMMAD', 'MOCHAMAD', 'MUHAMMAD', 'MOHAMMAD', 'FITRIONO', 'ARDIANSAH', 'ARDIANSYAH',
            'ARDIAN', 'AFIFAH', 'PURNOMO', 'PURNAMA', 'SULIANAH', 'SUNARTI', 'MUJIONO', 'SOLIKAN',
            'RIFAH', 'KASMINAH', 'MARIJAN', 'MUKTI', 'NGALI', 'ALIYUL', 'ANDIM', 'ANISYAH',
            'NAFFISA', 'IZZAH', 'INAYAH', 'HAIDAR', 'INTAN', 'RAHMAWATI', 'FADILAH', 'SYAFA',
            'PRATIWI', 'SULAMI', 'BASORI', 'RAHMA', 'WATI', 'PUTRI', 'PUTRA', 'NURUL', 'KHUSNAH',
            'KHASANAH', 'AULIA', 'SITI', 'AGUS', 'SRI', 'DWI', 'TRI', 'CATUR', 'EKO', 'BAYU',
            'RIZKY', 'FEBRI', 'RAMADHAN', 'KURNIAWAN', 'SETIAWAN', 'HERMAWAN', 'LESTARI', 'PURWANTI',
            'SUSANTI', 'MAHARANI', 'WULANDARI', 'FEBRIANI', 'SEPTIANI', 'APRILLIA', 'KUSUMA',
            'FIRMANSYAH', 'HIDAYAT', 'PRATAMA', 'SULISTYO', 'SAPUTRA', 'SAPUTRI', 'FATIMAH',
            'ZAHRA', 'BAMBANG', 'HARIYANTO', 'SUDARMAN', 'HERU', 'SUPRIYANTO', 'SURYADI',
            'WIBOWO', 'WIJAYA', 'FACHRUDIN', 'SUSILO', 'CHANDRA', 'BUDI', 'SANTOSO', 'HADI',
            'MULYONO', 'IRWAN', 'INDRA', 'REZA', 'ALAMSIAH', 'FIRDAUS', 'ROHMAN', 'RAHMAN',
            'SOFYAN', 'SEPTIAN', 'ANDI', 'AHMAD', 'ACHMAD', 'AMIR', 'AJIR', 'ANWAR',
            'HIDAYATULLAH', 'HASAN', 'HUSEIN', 'ISKANDAR', 'ILHAM', 'IWAN', 'JAMAL', 'JOKO',
            'KARTIKA', 'LUKMAN', 'MAULANA', 'NOVI', 'NUGROHO', 'OKTA', 'PERDANA', 'RATNA',
            'RIZAL', 'RUDI', 'SAIFUL', 'SLAMET', 'SUGIARTO', 'SUKARNO', 'SUHARTO', 'SYAMSUL',
            'TAUFIK', 'UTAMI', 'WAHYU', 'WIBISONO', 'YULIA', 'YULI', 'YUNUS', 'YUSUF', 'ZULKARNAIN',
            'ANI', 'EDI', 'DSN', 'BALONG', 'BESUK', 'BESOK', 'DUSUN', 'KAMPUNG', 'KMP', 'JL', 'JLN'
        ];

        usort($tokens, static function ($a, $b) {
            return strlen($b) <=> strlen($a);
        });

        $words      = preg_split('/\s+/', $name);
        $finalWords = [];

        foreach ($words as $word) {
            $cleanWord = trim($word);
            if ($cleanWord === '' || strlen($cleanWord) <= 3) {
                $finalWords[] = $cleanWord;
                continue;
            }

            $remaining = strtoupper($cleanWord);
            $subWords  = [];

            while (strlen($remaining) > 0) {
                $matched = false;
                foreach ($tokens as $token) {
                    if (strpos($remaining, $token) === 0) {
                        $subWords[] = $token;
                        $remaining  = substr($remaining, strlen($token));
                        $matched    = true;
                        break;
                    }
                }
                if (! $matched) {
                    $subWords[] = $remaining;
                    break;
                }
            }

            $finalWords[] = implode(' ', $subWords);
        }

        return implode(' ', array_filter($finalWords));
    }

    private static function formatDate(string $dateStr): string
    {
        $parts = preg_split('/[\-\/]/', $dateStr);
        if (count($parts) === 3) {
            return sprintf('%04d-%02d-%02d', (int) $parts[2], (int) $parts[1], (int) $parts[0]);
        }

        return date('Y-m-d');
    }

    public static function cleanOcrDigitString(string $str): string
    {
        $map = [
            'O' => '0', 'o' => '0', 'D' => '0',
            'I' => '1', 'l' => '1', 'i' => '1', '|' => '1',
            'Z' => '2', 'z' => '2',
            'S' => '5', 's' => '5',
            'B' => '8', 'b' => '8',
            'g' => '9', 'q' => '9',
        ];
        $converted = strtr($str, $map);

        return preg_replace('/[^0-9]/', '', $converted);
    }
}
