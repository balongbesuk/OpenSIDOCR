<style type="text/css">
	.slider-option-btn {
		text-align: left !important;
		padding: 12px 16px !important;
		margin-bottom: 12px !important;
		border: 1px solid #cbd5e1 !important;
		border-radius: 6px !important;
		background: #ffffff !important;
		color: #334155 !important;
		white-space: normal !important;
		transition: all 0.15s ease-in-out !important;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
		cursor: pointer !important;
	}

	.slider-option-btn:hover {
		background: #f8fafc !important;
		border-color: #94a3b8 !important;
		color: #1e293b !important;
	}

	.slider-option-btn.active,
	.slider-option-btn:active {
		background-color: #f0f9ff !important;
		border-color: #0284c7 !important;
		color: #0369a1 !important;
		box-shadow: 0 0 0 1px #0284c7, 0 2px 4px rgba(2, 132, 199, 0.12) !important;
	}

	.slider-option-btn .slider-option-content {
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.slider-option-btn .slider-radio-icon {
		font-size: 18px;
		color: #94a3b8;
		flex-shrink: 0;
		transition: color 0.15s ease-in-out;
	}

	.slider-option-btn.active .slider-radio-icon {
		color: #0284c7;
	}

	.slider-option-btn.active .slider-radio-icon:before {
		content: "\f192"; /* fa-dot-circle-o */
	}

	.slider-option-btn:not(.active) .slider-radio-icon:before {
		content: "\f10c"; /* fa-circle-o */
	}

	.slider-option-btn .slider-option-text {
		flex: 1;
	}

	.slider-option-btn .slider-option-text strong {
		display: block;
		font-size: 14px;
		font-weight: 600;
		line-height: 1.3;
		margin-bottom: 2px;
	}

	.slider-option-btn .slider-option-text small {
		display: block;
		font-size: 12px;
		line-height: 1.4;
		color: #64748b;
	}

	.slider-option-btn.active .slider-option-text small {
		color: #0369a1;
		opacity: 0.85;
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Slider Besar</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Pengaturan Slider Besar</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" action="<?= site_url('web/update_slider') ?>" method="POST" class="form-horizontal">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"><strong>Sumber Gambar Slider</strong></h3>
						</div>
						<div class="box-body">
							<p class="text-muted" style="margin-bottom: 15px; font-size: 13px;">
								Pilih sumber gambar yang akan ditampilkan pada slider besar halaman utama website:
							</p>
							<div class="row">
								<div class="col-sm-12 col-md-8 col-lg-6">
									<div data-toggle="buttons">
										<label class="btn btn-default btn-block slider-option-btn <?= ($this->setting->sumber_gambar_slider == '1') ? 'active' : '' ?>">
											<input id="sumber1" type="radio" name="pilihan_sumber" class="hidden" value="1" <?= ($this->setting->sumber_gambar_slider == '1') ? 'checked' : '' ?> autocomplete="off">
											<div class="slider-option-content">
												<i class="fa fa-circle-o slider-radio-icon"></i>
												<div class="slider-option-text">
													<strong>Artikel Terbaru</strong>
													<small>10 gambar utama dari artikel terbaru</small>
												</div>
											</div>
										</label>

										<label class="btn btn-default btn-block slider-option-btn <?= ($this->setting->sumber_gambar_slider == '2') ? 'active' : '' ?>">
											<input id="sumber2" type="radio" name="pilihan_sumber" class="hidden" value="2" <?= ($this->setting->sumber_gambar_slider == '2') ? 'checked' : '' ?> autocomplete="off">
											<div class="slider-option-content">
												<i class="fa fa-circle-o slider-radio-icon"></i>
												<div class="slider-option-text">
													<strong>Artikel Terbaru Pilihan</strong>
													<small>10 gambar utama artikel terbaru yang masuk ke slider atas</small>
												</div>
											</div>
										</label>

										<label class="btn btn-default btn-block slider-option-btn <?= ($this->setting->sumber_gambar_slider == '3') ? 'active' : '' ?>">
											<input id="sumber3" type="radio" name="pilihan_sumber" class="hidden" value="3" <?= ($this->setting->sumber_gambar_slider == '3') ? 'checked' : '' ?> autocomplete="off">
											<div class="slider-option-content">
												<i class="fa fa-circle-o slider-radio-icon"></i>
												<div class="slider-option-text">
													<strong>Album Galeri</strong>
													<small>Gambar dalam album galeri yang dimasukkan ke slider</small>
												</div>
											</div>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="box-footer">
							<?php if ($this->CI->cek_hak_akses('u')): ?>
								<button type="submit" class="btn btn-social btn-flat btn-info btn-sm pull-right confirm"><i class="fa fa-check"></i> Simpan</button>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
