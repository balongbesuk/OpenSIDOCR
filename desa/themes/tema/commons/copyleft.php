<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<footer class="bg-slate-900 pt-24 pb-12 overflow-hidden relative">
    <!-- Abstract Background Decor -->
    <div class="absolute right-0 bottom-0 w-[500px] h-[500px] bg-brand-600/10 rounded-full blur-[120px]"></div>

    <div class="container mx-auto px-4 relative z-10">
        
        <!-- Top Footer -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 mb-20">
            
            <!-- Village Info -->
            <div class="lg:col-span-5 space-y-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center p-2">
                        <img src="<?= gambar_desa($desa['logo']) ?>" alt="Logo Desa" class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <h3 class="font-display font-black text-2xl text-white tracking-tight leading-none uppercase"><?= html_escape($desa['nama_desa']) ?></h3>
                        <p class="text-[10px] font-bold text-brand-500 uppercase tracking-[0.3em] mt-2">Portal Resmi Pemerintah Desa</p>
                    </div>
                </div>
                <p class="text-slate-300 text-lg leading-relaxed max-w-md">
                    Berkomitmen mewujudkan tata kelola pemerintahan desa yang transparan, akuntabel, dan inovatif demi kesejahteraan masyarakat.
                </p>
                <!-- Social Links -->
                <div class="flex flex-wrap items-center gap-3">
                    <?php foreach ($sosmed as $data): ?>
                        <?php if (!empty($data['link'])): ?>
                            <a href="<?= html_escape($data['link']) ?>" target="_blank" rel="noopener noreferrer" title="<?= html_escape($data['nama']) ?>" class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-brand-600 hover:border-brand-600 transition-all duration-300" aria-label="<?= html_escape($data['nama']) ?>">
                                <i class="fa-brands fa-<?= strtolower($data['nama']) === 'facebook' ? 'facebook-f' : strtolower($data['nama']) ?>" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <style>
                        /* Sembunyikan teks penjelasan agar hanya menampilkan tombol di samping medsos */
                        .onesignal-customlink-explanation {
                            display: none !important;
                        }

                        /* Style container agar sejajar */
                        .onesignal-customlink-container {
                            display: inline-flex !important;
                            align-items: center !important;
                        }

                        /* Style tombol Custom Link OneSignal */
                        .onesignal-customlink-subscribe.button {
                            background-color: #2563eb !important;
                            color: #ffffff !important;
                            border: none !important;
                            border-radius: 0.75rem !important;
                            padding: 0 1.25rem !important;
                            height: 3rem !important; /* Samakan tinggi dengan ikon medsos (48px) */
                            font-family: 'Outfit', sans-serif !important;
                            font-weight: 600 !important;
                            font-size: 0.875rem !important;
                            transition: all 0.3s ease !important;
                            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2), 0 2px 4px -2px rgba(37, 99, 235, 0.2) !important;
                            display: inline-flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            cursor: pointer !important;
                        }

                        .onesignal-customlink-subscribe.button:hover {
                            background-color: #1d4ed8 !important;
                            transform: translateY(-2px) !important;
                            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3), 0 4px 6px -4px rgba(37, 99, 235, 0.3) !important;
                        }

                        .onesignal-customlink-subscribe.button:active {
                            transform: translateY(0) !important;
                        }
                    </style>
                    <div class="onesignal-customlink-container ml-1"></div>
                </div>
            </div>

            <!-- Contact Grid -->
            <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <h4 class="text-white font-display font-extrabold text-xl">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center shrink-0 transition-colors group-hover:bg-brand-500 group-hover:text-white">
                                 <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            </div>
                            <div class="text-slate-300 text-sm leading-relaxed">
                                <?= html_escape($desa['alamat_kantor']) ?><br>
                                <?= html_escape($this->setting->sebutan_kecamatan) ?> <?= html_escape($desa['nama_kecamatan']) ?>, <?= html_escape($desa['nama_kabupaten']) ?> <?= html_escape($desa['kode_pos']) ?>
                            </div>
                        </li>
                        <li class="flex gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-500 flex items-center justify-center shrink-0 transition-colors group-hover:bg-brand-500 group-hover:text-white">
                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="text-slate-300 text-sm">
                                <a href="tel:<?= $desa['telepon'] ?>" class="block font-bold text-white hover:text-brand-500 transition-colors" aria-label="Telepon Desa: <?= $desa['telepon'] ?>"><?= $desa['telepon'] ?: '-' ?></a>
                                Jam Kerja: 08:00 - 15:00 WIB
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h4 class="text-white font-display font-extrabold text-xl">Email Resmi</h4>
                    <div class="p-6 rounded-3xl bg-white/5 border border-white/10 space-y-4">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope-open-text text-brand-500 text-2xl"></i>
                            <?php $email_desa = !empty($desa['email_desa']) ? $desa['email_desa'] : (!empty($desa['email']) ? $desa['email'] : ''); ?>
                            <a href="<?= $email_desa ? 'mailto:' . html_escape($email_desa) : '#' ?>" class="text-white font-bold text-sm hover:text-brand-500 transition-colors tracking-tight">
                                <?= $email_desa ? html_escape($email_desa) : 'Email belum tersedia' ?>
                            </a>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Email Resmi Pemerintah Desa.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-slate-300 text-[10px] font-display font-black uppercase tracking-widest leading-none">
                &copy; <?= date("Y") ?> <span class="text-white">Pemerintah Desa <?= html_escape($desa['nama_desa']) ?></span>. All rights reserved.
            </div>
            <div class="flex items-center gap-6 text-[10px] font-display font-black uppercase tracking-[0.2em] text-slate-300">
                <a href="<?= site_url('siteman') ?>" class="hover:text-white transition-colors">Desa Digital</a>
                <span class="w-1 h-1 rounded-full bg-slate-800"></span>
                <span class="text-slate-500">Privasi mengikuti kebijakan portal OpenSID</span>
                <span class="w-1 h-1 rounded-full bg-slate-800"></span>
                <span>Powered by <a href="https://github.com/OpenSID/OpenSID" target="_blank" rel="noopener noreferrer" class="text-brand-400 hover:text-brand-300 transition-colors underline decoration-brand-400/30 underline-offset-4">OpenSID</a></span>
            </div>
        </div>

    </div>
</footer>
