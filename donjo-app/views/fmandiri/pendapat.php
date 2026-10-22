<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View Modal Penilaian Kepuasan Layanan Mandiri
 * Redesain Modern Card Dialog (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/pendapat.php
 */

$list_pendapat = unserialize(NILAI_PENDAPAT);

// Konfigurasi visual untuk setiap opsi penilaian kepuasan
$config_pendapat = [
    1 => [
        'label'        => 'Sangat Puas',
        'color_theme'  => 'emerald',
        'border_hover' => 'hover:border-emerald-400 hover:bg-emerald-50/80 hover:shadow-emerald-500/15',
        'text_active'  => 'text-slate-800 group-hover:text-emerald-700',
    ],
    2 => [
        'label'        => 'Puas',
        'color_theme'  => 'sky',
        'border_hover' => 'hover:border-sky-400 hover:bg-sky-50/80 hover:shadow-sky-500/15',
        'text_active'  => 'text-slate-800 group-hover:text-sky-700',
    ],
    3 => [
        'label'        => 'Cukup',
        'color_theme'  => 'amber',
        'border_hover' => 'hover:border-amber-400 hover:bg-amber-50/80 hover:shadow-amber-500/15',
        'text_active'  => 'text-slate-800 group-hover:text-amber-700',
    ],
    4 => [
        'label'        => 'Buruk',
        'color_theme'  => 'rose',
        'border_hover' => 'hover:border-rose-400 hover:bg-rose-50/80 hover:shadow-rose-500/15',
        'text_active'  => 'text-slate-800 group-hover:text-rose-700',
    ],
];
?>

<div class="modal fade" id="pendapat" tabindex="-1" role="dialog" aria-labelledby="modalPendapatLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content relative bg-white rounded-3xl shadow-2xl border border-slate-100/90 overflow-hidden text-slate-800">

			<!-- Ambient Top Color Glow Accent -->
			<div class="h-1.5 w-full bg-gradient-to-r from-emerald-400 via-sky-400 via-amber-400 to-rose-400"></div>

			<!-- Tombol Tutup Silang (X) di Pojok Kanan Atas -->
			<button type="button" class="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-slate-100/90 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition-all cursor-pointer" data-dismiss="modal" title="Tutup" aria-label="Tutup">
				<i class="fa-solid fa-xmark text-sm"></i>
			</button>

			<div class="p-6 sm:p-8 text-center">

				<!-- Icon Badge Header: Fixed 56x56 px with star -->
				<div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-400 to-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/25 mx-auto mb-4 transform transition-transform duration-300 hover:scale-105">
					<i class="fa-solid fa-star text-2xl drop-shadow-xs"></i>
				</div>

				<!-- Judul & Keterangan Ramah -->
				<h3 class="font-display text-xl sm:text-2xl font-bold text-slate-900 tracking-tight mb-2" id="modalPendapatLabel">
					Bagaimana Pelayanan Kami?
				</h3>
				<p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto leading-relaxed">
					Penilaian Anda sangat berharga untuk terus meningkatkan kualitas dan keramahan pelayanan publik Desa.
				</p>

				<!-- Grid 4 Pilihan Kepuasan -->
				<div class="grid grid-cols-4 gap-2.5 sm:gap-4 my-6 sm:my-7">

					<?php foreach ($list_pendapat as $key => $value) :
						$cfg = $config_pendapat[$key] ?? [
							'label'        => $value,
							'border_hover' => 'hover:border-sky-400 hover:bg-sky-50/80',
							'text_active'  => 'text-slate-800',
						];
					?>
						<a href="<?= site_url("layanan-mandiri/pendapat/{$key}"); ?>"
						   class="group relative flex flex-col items-center justify-between p-3 sm:p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 active:scale-95 no-underline <?= $cfg['border_hover']; ?>">

							<!-- Emotikon SVG Proporsional & Tajam -->
							<div class="relative w-12 h-12 sm:w-14 sm:h-14 mb-2 flex items-center justify-center">
								<?php if ($key == 1) : ?>
									<!-- 1: Sangat Puas (Radiant Beaming Joy) -->
									<svg class="w-full h-full drop-shadow-sm transition-transform duration-200 group-hover:scale-110" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
										<defs>
											<radialGradient id="grad-sp" cx="35%" cy="30%" r="65%">
												<stop offset="0%" stop-color="#FEF08A" />
												<stop offset="100%" stop-color="#F59E0B" />
											</radialGradient>
										</defs>
										<circle cx="32" cy="32" r="28" fill="url(#grad-sp)" />
										<ellipse cx="14" cy="37" rx="5" ry="3" fill="#FB7185" fill-opacity="0.6" />
										<ellipse cx="50" cy="37" rx="5" ry="3" fill="#FB7185" fill-opacity="0.6" />
										<path d="M18 27 Q22 20 26 27" stroke="#78350F" stroke-width="3.2" stroke-linecap="round" fill="none" />
										<path d="M38 27 Q42 20 46 27" stroke="#78350F" stroke-width="3.2" stroke-linecap="round" fill="none" />
										<path d="M19 34 C19 46 45 46 45 34 Z" fill="#78350F" />
										<path d="M22 34 C25 38 39 38 42 34 Z" fill="#FFFFFF" />
										<path d="M26 41 C28 45 36 45 38 41 Z" fill="#FB7185" />
									</svg>

								<?php elseif ($key == 2) : ?>
									<!-- 2: Puas (Warm Cheerful Smile) -->
									<svg class="w-full h-full drop-shadow-sm transition-transform duration-200 group-hover:scale-110" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
										<defs>
											<radialGradient id="grad-p" cx="35%" cy="30%" r="65%">
												<stop offset="0%" stop-color="#FEF9C3" />
												<stop offset="100%" stop-color="#FBBF24" />
											</radialGradient>
										</defs>
										<circle cx="32" cy="32" r="28" fill="url(#grad-p)" />
										<ellipse cx="15" cy="37" rx="4" ry="2.5" fill="#FB923C" fill-opacity="0.45" />
										<ellipse cx="49" cy="37" rx="4" ry="2.5" fill="#FB923C" fill-opacity="0.45" />
										<ellipse cx="22" cy="27" rx="3.5" ry="4.5" fill="#78350F" />
										<ellipse cx="42" cy="27" rx="3.5" ry="4.5" fill="#78350F" />
										<circle cx="21" cy="25.5" r="1.3" fill="#FFFFFF" />
										<circle cx="41" cy="25.5" r="1.3" fill="#FFFFFF" />
										<path d="M20 35 Q32 46 44 35" stroke="#78350F" stroke-width="3.4" stroke-linecap="round" fill="none" />
									</svg>

								<?php elseif ($key == 3) : ?>
									<!-- 3: Cukup (Calm Neutral Expression) -->
									<svg class="w-full h-full drop-shadow-sm transition-transform duration-200 group-hover:scale-110" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
										<defs>
											<radialGradient id="grad-c" cx="35%" cy="30%" r="65%">
												<stop offset="0%" stop-color="#FEF08A" />
												<stop offset="100%" stop-color="#F59E0B" />
											</radialGradient>
										</defs>
										<circle cx="32" cy="32" r="28" fill="url(#grad-c)" />
										<ellipse cx="22" cy="28" rx="3.5" ry="4.5" fill="#78350F" />
										<ellipse cx="42" cy="28" rx="3.5" ry="4.5" fill="#78350F" />
										<circle cx="21" cy="26.5" r="1.2" fill="#FFFFFF" />
										<circle cx="41" cy="26.5" r="1.2" fill="#FFFFFF" />
										<line x1="22" y1="39" x2="42" y2="39" stroke="#78350F" stroke-width="3.5" stroke-linecap="round" />
									</svg>

								<?php else : ?>
									<!-- 4: Buruk (Disappointed / Frown Expression) -->
									<svg class="w-full h-full drop-shadow-sm transition-transform duration-200 group-hover:scale-110" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
										<defs>
											<radialGradient id="grad-b" cx="35%" cy="30%" r="65%">
												<stop offset="0%" stop-color="#FECDD3" />
												<stop offset="100%" stop-color="#FB7185" />
											</radialGradient>
										</defs>
										<circle cx="32" cy="32" r="28" fill="url(#grad-b)" />
										<path d="M17 22 L26 25" stroke="#881337" stroke-width="2.6" stroke-linecap="round" />
										<path d="M47 22 L38 25" stroke="#881337" stroke-width="2.6" stroke-linecap="round" />
										<ellipse cx="22" cy="29" rx="3.2" ry="4" fill="#881337" />
										<ellipse cx="42" cy="29" rx="3.2" ry="4" fill="#881337" />
										<path d="M21 42 Q32 34 43 42" stroke="#881337" stroke-width="3.4" stroke-linecap="round" fill="none" />
									</svg>
								<?php endif; ?>
							</div>

							<!-- Label Penilaian -->
							<span class="text-xs sm:text-sm font-bold text-slate-800 transition-colors leading-tight text-center block <?= $cfg['text_active']; ?>">
								<?= $value; ?>
							</span>
						</a>
					<?php endforeach; ?>

				</div>

				<!-- Footer Aksi Pilihan: Berdampingan Kiri-Kanan (Side-by-Side di Mobile & Desktop) -->
				<div class="border-t border-slate-100 pt-4 mt-1 grid grid-cols-2 gap-2 sm:gap-3">
					<button type="button" class="w-full py-2.5 px-2.5 sm:px-4 rounded-xl text-slate-600 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 font-semibold text-xs sm:text-sm transition-all flex items-center justify-center gap-1.5 sm:gap-2 cursor-pointer" data-dismiss="modal">
						<i class="fa-solid fa-arrow-left text-xs text-slate-400"></i>
						<span class="truncate">Tetap di Sini</span>
					</button>

					<a href="<?= site_url('layanan-mandiri/keluar'); ?>" class="w-full py-2.5 px-2.5 sm:px-4 rounded-xl text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 hover:border-rose-200 active:bg-rose-200 font-semibold text-xs sm:text-sm transition-all flex items-center justify-center gap-1.5 sm:gap-2 no-underline cursor-pointer">
						<span class="truncate">Lewati & Keluar</span>
						<i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
					</a>
				</div>

			</div>
		</div>
	</div>
</div>

<style>
/* Scoped Styling untuk Modal Pendapat */
#pendapat .modal-dialog {
	max-width: 520px;
	width: 92%;
	margin: 2rem auto;
}
@media (min-width: 768px) {
	#pendapat .modal-dialog {
		margin: 12vh auto;
	}
}
#pendapat .modal-content {
	border: none;
	border-radius: 1.5rem;
	box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(15, 23, 42, 0.05);
	background: #ffffff;
}
#pendapat.fade .modal-dialog {
	transform: scale(0.92) translateY(12px);
	transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease-out;
	opacity: 0;
}
#pendapat.in .modal-dialog {
	transform: scale(1) translateY(0);
	opacity: 1;
}
.modal-backdrop.in {
	opacity: 0.65;
	backdrop-filter: blur(4px);
	-webkit-backdrop-filter: blur(4px);
}
</style>
