<?php
$info         = $ocr_info ?? [];
$is_available = ! empty($info['is_available']);
$is_latest    = ! empty($info['is_latest']);
$has_exec     = ! empty($info['has_exec']);
$has_python   = ! empty($info['has_python']);
$python_ver   = $info['python_version'] ?? 'Tidak Terdeteksi';
$has_new      = ! empty($info['has_new']);
$has_onnx     = ! empty($info['has_onnx']);
$has_opencv   = ! empty($info['has_opencv']);
$missing      = $info['missing_packages'] ?? [];
$has_any_pkg  = $has_new || ! empty($info['has_old']) || $has_onnx || $has_opencv;
?>
<div class="modal-body">
	<div id="ocr_status_alert" class="alert alert-<?= $is_available ? ($is_latest ? 'success' : 'info') : 'warning' ?>" style="margin-bottom: 12px;">
		<div class="row">
			<div class="col-sm-7">
				<i class="fa fa-<?= $is_available ? 'check-circle' : 'exclamation-triangle' ?>"></i> 
				<strong>Status Engine OCR:</strong> 
				<?php if (! $has_exec): ?>
					PHP <code>exec()</code> Dinonaktifkan ⛔
				<?php elseif (! $has_python): ?>
					Python 3 Belum Terpasang di Hosting ⚠️
				<?php elseif (! $is_available): ?>
					<?php if (! empty($missing)): ?>
						Dependensi Kurang: <code><?= implode(', ', $missing) ?></code> ⚠️
					<?php else: ?>
						Engine Belum Siap / Belum Terpasang ⚠️
					<?php endif; ?>
				<?php elseif ($is_latest): ?>
					Ready (RapidOCR PP-OCRv4 + ONNX Runtime + OpenCV ✅)
				<?php else: ?>
					Ready (RapidOCR ONNX Aktif ⚠️)
				<?php endif; ?>
			</div>
			<div class="col-sm-5 text-right">
				<?php if ($has_exec && $has_python): ?>
					<?php if ($is_available): ?>
						<button type="button" class="btn btn-xs btn-default" onclick="doInstallOcr(true)" title="Install ulang atau perbarui paket dependensi OCR">
							<i class="fa fa-refresh text-primary"></i> Reinstall / Update
						</button>
						<button type="button" class="btn btn-xs btn-default text-danger" onclick="doUninstallOcr()" title="Hapus modul OCR dari hosting jika ingin menghemat penyimpanan">
							<i class="fa fa-trash"></i> Uninstall
						</button>
					<?php else: ?>
						<button type="button" id="btn_fix_ocr" class="btn btn-xs btn-primary" onclick="doInstallOcr(false)">
							<i class="fa fa-wrench"></i> <?= $has_any_pkg ? 'Perbaiki / Pasang Dependensi' : 'Install Engine (1-Click)' ?>
						</button>
						<?php if ($has_any_pkg): ?>
							<button type="button" class="btn btn-xs btn-default text-danger" onclick="doUninstallOcr()" title="Hapus modul OCR yang tersisa">
								<i class="fa fa-trash"></i> Uninstall
							</button>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>

		<!-- Detail Diagnostik Lingkungan Hosting -->
		<div style="margin-top: 10px; font-size: 11.5px; border-top: 1px dashed rgba(0,0,0,0.15); padding-top: 6px;">
			<strong><i class="fa fa-server"></i> Diagnostik Hosting:</strong>
			PHP <code>exec()</code>: <?= $has_exec ? '<span class="text-success font-weight-bold">Aktif ✅</span>' : '<span class="text-danger font-weight-bold">Nonaktif ⛔</span>' ?> |
			Python: <?= $has_python ? '<span class="text-success font-weight-bold">' . htmlspecialchars($python_ver) . ' ✅</span>' : '<span class="text-danger font-weight-bold">Tidak Ditemukan ⛔</span>' ?> |
			ONNX Runtime: <?= $has_onnx ? '<span class="text-success font-weight-bold">Ada ✅</span>' : '<span class="text-danger font-weight-bold">Belum ❌</span>' ?> |
			RapidOCR: <?= $has_new ? '<span class="text-success font-weight-bold">Ada ✅</span>' : '<span class="text-danger font-weight-bold">Belum ❌</span>' ?> |
			OpenCV: <?= $has_opencv ? '<span class="text-success font-weight-bold">Ada ✅</span>' : '<span class="text-danger font-weight-bold">Belum ❌</span>' ?>
		</div>
	</div>

	<?php if (! $has_exec): ?>
		<div class="alert alert-danger" style="font-size: 13px;">
			<i class="fa fa-ban"></i> <strong>Hosting Membatasi Fungsi PHP:</strong><br>
			Fungsi <code>exec()</code> dinonaktifkan di hosting ini. Engine OCR memerlukan <code>exec()</code> untuk memanggil proses pembaca teks.
			Silakan aktifkan fungsi <code>exec</code> di cPanel melalui menu <strong>Select PHP Version</strong> &rarr; tab <strong>Options</strong> &rarr; hapus <code>exec</code> dari baris <em>disable_functions</em>, atau hubungi penyedia hosting Anda.
		</div>
	<?php elseif (! $has_python): ?>
		<div class="alert alert-warning" style="font-size: 13px;">
			<i class="fa fa-exclamation-triangle"></i> <strong>Python Tidak Ditemukan:</strong><br>
			Perintah <code>python3</code> tidak ditemukan di lingkungan server hosting Anda. Silakan hubungi penyedia hosting atau aktifkan fitur Python melalui menu <strong>Setup Python App</strong> di cPanel.
		</div>
	<?php elseif (! $is_available): ?>
		<div id="install_section" class="text-center" style="padding: 15px 10px; background: #fff8e1; border: 1px dashed #ffe082; border-radius: 5px; margin-bottom: 15px;">
			<p style="font-size: 14px; color: #5d4037; margin-bottom: 5px;">
				<?php if (! empty($missing)): ?>
					Modul dependensi OCR belum lengkap di server hosting: <strong><?= implode(', ', $missing) ?></strong>
				<?php else: ?>
					Engine pembaca teks <strong>RapidOCR ONNX</strong> belum terpasang di server hosting ini.
				<?php endif; ?>
			</p>
			<p class="text-muted"><small>Server hosting Anda mendukung Python & fungsi <code>exec()</code>. Anda dapat memasang atau melengkapi modul secara otomatis dengan 1-Klik di bawah ini:</small></p>
			<button type="button" id="btn_install_ocr" class="btn btn-primary btn-md" onclick="doInstallOcr(false)">
				<i class="fa fa-download"></i> <?= $has_any_pkg ? 'Pasang / Perbaiki Dependensi OCR Sekarang (1-Click)' : 'Install Engine RapidOCR Sekarang (1-Click)' ?>
			</button>
		</div>
	<?php endif; ?>

	<div id="install_loading" style="display:none; margin-bottom: 15px; padding: 15px; background: #f0f7fd; border: 1px solid #d0e4f7; border-radius: 5px; text-align: center;">
		<i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
		<p style="margin-top:8px; font-weight: 500; color: #1e3a8a;">
			<span id="loading_text">Sedang memproses paket dependensi OCR di server...</span><br>
			<small class="text-muted">Proses ini memakan waktu sekitar 15-40 detik melalui jaringan server hosting. Mohon jangan tutup jendela ini.</small>
		</p>
	</div>

	<script>
	function doInstallOcr(isReinstall) {
		var confirmMsg = isReinstall 
			? 'Apakah Anda ingin meng-install ulang / memperbarui RapidOCR, ONNX Runtime, dan OpenCV di server sekarang?' 
			: 'Apakah Anda ingin meng-install RapidOCR ONNX Engine di server sekarang?';
		if (!confirm(confirmMsg)) return;

		$('#btn_install_ocr, #btn_fix_ocr').prop('disabled', true).hide();
		$('#loading_text').text(isReinstall ? 'Sedang meng-install ulang paket RapidOCR, ONNX Runtime & OpenCV di server...' : 'Sedang mengunduh & memasang RapidOCR ONNX Engine di server...');
		$('#install_loading').show();

		$.ajax({
			url: '<?= site_url('keluarga/ajax_install_ocr') ?>',
			type: 'POST',
			dataType: 'json',
			success: function(res) {
				alert(res.message);
				$('#modalBox').load('<?= site_url('keluarga/dialog_import_scan_kk') ?>');
			},
			error: function(xhr, status, error) {
				alert('Terjadi kesalahan koneksi server: ' + error);
				$('#btn_install_ocr, #btn_fix_ocr').prop('disabled', false).show();
				$('#install_loading').hide();
			}
		});
	}

	function doUninstallOcr() {
		if (!confirm('Apakah Anda yakin ingin menghapus (uninstall) engine RapidOCR, ONNX Runtime, dan OpenCV dari server hosting?')) return;

		$('#install_loading').show();
		$('#loading_text').text('Sedang menghapus paket OCR dari server hosting...');

		$.ajax({
			url: '<?= site_url('keluarga/ajax_uninstall_ocr') ?>',
			type: 'POST',
			dataType: 'json',
			success: function(res) {
				alert(res.message);
				$('#modalBox').load('<?= site_url('keluarga/dialog_import_scan_kk') ?>');
			},
			error: function(xhr, status, error) {
				alert('Terjadi kesalahan koneksi server: ' + error);
				$('#install_loading').hide();
			}
		});
	}
	</script>

	<form id="form_import_scan" action="<?= site_url('keluarga/proses_import_scan_kk') ?>" method="POST" enctype="multipart/form-data" class="form-horizontal" <?= ! $is_available ? 'style="display:none;"' : '' ?>>
		<?php if ($this->config->config['csrf_protection']): ?>
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
		<?php endif; ?>
		<div class="form-group">
			<label for="kk_scan" class="col-sm-3 control-label">File Foto / Scan KK</label>
			<div class="col-sm-8">
				<input type="file" name="kk_scan" id="kk_scan" class="form-control input-sm" accept=".jpg,.jpeg,.png,.pdf" required>
				<p class="help-block"><i>Unggah hasil scan / foto fotokopi Kartu Keluarga (.jpg, .jpeg, .png, .pdf). Sistem akan membaca teks dokumen menggunakan RapidOCR ONNX Engine.</i></p>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
			<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-magic"></i> Unggah & Scan OCR</button>
		</div>
	</form>
</div>
