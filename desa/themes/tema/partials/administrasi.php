<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="relative py-12 md:py-20 overflow-hidden">
    <!-- Decor Background -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-600/5 rounded-full blur-[100px] -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-accent/5 rounded-full blur-[100px] -z-10"></div>

    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="max-w-3xl mb-12 md:mb-20">
            <h2 class="font-display font-black text-4xl md:text-6xl text-slate-900 dark:text-white tracking-tighter leading-none mb-6">
                Administrasi <span class="text-brand-600">Kependudukan.</span>
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-lg md:text-xl font-medium leading-relaxed">
                Panduan lengkap persyaratan dan alur pengurusan dokumen kependudukan di Desa <?= $desa['nama_desa'] ?>. Pelayanan cepat, mudah, dan transparan.
            </p>
        </div>

        <!-- Custom Tabs Navigation -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Navbar Tabs -->
            <div class="lg:col-span-4 space-y-3">
                <nav class="flex flex-col gap-3 p-4 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm shadow-slate-200/50 dark:shadow-slate-950/50 backdrop-blur-xl">
                    <?php 
                    $docs = [
                        'ektp' => ['label' => 'E-KTP', 'icon' => 'fa-id-card', 'desc' => 'Identitas Kependudukan Elektronik'],
                        'kk' => ['label' => 'Kartu Keluarga', 'icon' => 'fa-users', 'desc' => 'Pendataan Anggota Keluarga'],
                        'pindah' => ['label' => 'Surat Pindah', 'icon' => 'fa-route', 'desc' => 'Pindah Domisili Keluar/Masuk'],
                        'skck' => ['label' => 'SKCK', 'icon' => 'fa-file-shield', 'desc' => 'Surat Keterangan Catatan Kepolisian']
                    ];
                    foreach ($docs as $id => $item): ?>
                        <button onclick="switchAdminTab('<?= $id ?>')" id="admin-tab-<?= $id ?>" 
                            class="admin-nav-btn group flex items-center gap-4 p-5 rounded-[1.5rem] text-left transition-all duration-300 <?= $id === 'ektp' ? 'bg-brand-600 text-white shadow-xl shadow-brand-600/30' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' ?>">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors <?= $id === 'ektp' ? 'bg-white/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-brand-100 dark:group-hover:bg-brand-900/30' ?>">
                                <i class="fa-solid <?= $item['icon'] ?> text-lg <?= $id === 'ektp' ? 'text-white' : 'text-slate-500 dark:text-slate-500 group-hover:text-brand-600' ?>"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="block font-display font-black uppercase tracking-widest text-[10px] opacity-60 mb-1 leading-none">Dokumen</span>
                                <h4 class="font-display font-black text-sm md:text-base tracking-tight leading-none group-hover:text-brand-600 <?= $id === 'ektp' ? 'group-hover:text-white' : '' ?>">
                                    <?= $item['label'] ?>
                                </h4>
                            </div>
                        </button>
                    <?php endforeach; ?>
                </nav>

                <!-- Help Alert -->
                <div class="p-8 rounded-[2rem] bg-brand-50 dark:bg-brand-900/20 border border-brand-100 dark:border-brand-900/30">
                    <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center mb-4 shadow-lg shadow-brand-600/20">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h5 class="font-display font-black text-slate-900 dark:text-white leading-none mb-3">Butuh Bantuan?</h5>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Hubungi kantor desa jika Anda menemui kendala dalam persyaratan dokumen.</p>
                </div>
            </div>

            <!-- Tab Panels -->
            <div class="lg:col-span-8">
                <?php foreach ($docs as $id => $item): ?>
                    <div id="admin-panel-<?= $id ?>" class="admin-tab-panel animate-fade-in <?= $id === 'ektp' ? 'block' : 'hidden' ?>">
                        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 md:p-12 shadow-sm shadow-slate-200/50 dark:shadow-slate-950/50">
                            
                            <!-- Panel Header -->
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 border-b border-slate-50 dark:border-slate-800 pb-10">
                                <div class="space-y-3">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400 text-[10px] font-black uppercase tracking-widest">
                                        <i class="fa-solid fa-circle-check text-[8px]"></i> Layanan Mandiri
                                    </div>
                                    <h3 class="font-display font-black text-3xl md:text-5xl text-slate-900 dark:text-white tracking-tighter leading-none">
                                        Persyaratan <?= $item['label'] ?>
                                    </h3>
                                    <p class="text-slate-500 dark:text-slate-400 font-medium"><?= $item['desc'] ?></p>
                                </div>
                                <div class="shrink-0 flex items-center gap-3 px-6 py-4 bg-emerald-500 text-white rounded-2xl font-display font-black uppercase tracking-widest text-[10px] shadow-lg shadow-emerald-500/20">
                                    <i class="fa-solid fa-tags"></i> Biaya: Gratis
                                </div>
                            </div>

                            <!-- Content Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <!-- Persyaratan -->
                                <div class="space-y-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center">
                                            <i class="fa-solid fa-clipboard-list"></i>
                                        </div>
                                        <h5 class="font-display font-black text-slate-900 dark:text-white uppercase tracking-widest text-xs">Persyaratan Utama</h5>
                                    </div>
                                    <ul class="space-y-4">
                                        <?php 
                                        $reqs = [
                                            'ektp' => ['Surat Pengantar dari RT yang diketahui RW'],
                                            'kk' => ['Surat Pengantar dari RT yang diketahui RW'],
                                            'pindah' => ['Surat Pengantar dari RT yang diketahui RW', 'KTP / Identitas diri yang berlaku'],
                                            'skck' => ['Surat Pengantar dari RT yang diketahui RW', 'KTP / Identitas diri yang berlaku']
                                        ];
                                        foreach ($reqs[$id] as $req): ?>
                                            <li class="flex gap-4 group">
                                                <div class="w-6 h-6 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-brand-600 transition-colors">
                                                    <i class="fa-solid fa-check text-[10px] text-slate-400 group-hover:text-white"></i>
                                                </div>
                                                <span class="text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed"><?= $req ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                                <!-- Output -->
                                <div class="space-y-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center">
                                            <i class="fa-solid fa-file-export"></i>
                                        </div>
                                        <h5 class="font-display font-black text-slate-900 dark:text-white uppercase tracking-widest text-xs">Output Dokumen</h5>
                                    </div>
                                    <div class="p-6 rounded-[1.5rem] bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                                            <?php if ($id === 'skck'): ?>
                                                Surat Pengantar Desa untuk melakukan proses selanjutnya di Kepolisian.
                                            <?php else: ?>
                                                Surat Pengantar Desa untuk proses di Kecamatan atau Dinas Kependudukan (Dindukcapil) Kabupaten.
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <!-- Tip -->
                                    <div class="flex gap-3 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                        <i class="fa-solid fa-circle-info text-brand-600 mt-0.5"></i>
                                        Pastikan data RT/RW sudah terverifikasi dengan benar.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script>
function switchAdminTab(tabId) {
    // Hidden all panels
    document.querySelectorAll('.admin-tab-panel').forEach(p => {
        p.classList.add('hidden');
        p.classList.remove('block');
    });

    // Show active panel
    const activePanel = document.getElementById('admin-panel-' + tabId);
    activePanel.classList.remove('hidden');
    activePanel.classList.add('block');

    // Reset button styles
    document.querySelectorAll('.admin-nav-btn').forEach(btn => {
        btn.classList.remove('bg-brand-600', 'text-white', 'shadow-xl', 'shadow-brand-600/30');
        btn.classList.add('text-slate-600', 'dark:text-slate-400', 'hover:bg-slate-50', 'dark:hover:bg-slate-800');
        
        // Reset sub elements
        const iconContainer = btn.querySelector('div:first-child');
        const icon = btn.querySelector('i');
        const h4 = btn.querySelector('h4');
        
        iconContainer.classList.remove('bg-white/20');
        iconContainer.classList.add('bg-slate-100', 'dark:bg-slate-800');
        
        icon.classList.add('text-slate-500', 'dark:text-slate-500');
        icon.classList.remove('text-white');
        
        h4.classList.remove('group-hover:text-white');
        h4.classList.add('group-hover:text-brand-600');
    });

    // Set active button styles
    const activeBtn = document.getElementById('admin-tab-' + tabId);
    activeBtn.classList.add('bg-brand-600', 'text-white', 'shadow-xl', 'shadow-brand-600/30');
    activeBtn.classList.remove('text-slate-600', 'dark:text-slate-400', 'hover:bg-slate-50', 'dark:hover:bg-slate-800');

    const activeIconContainer = activeBtn.querySelector('div:first-child');
    const activeIcon = activeBtn.querySelector('i');
    const activeH4 = activeBtn.querySelector('h4');

    activeIconContainer.classList.add('bg-white/20');
    activeIconContainer.classList.remove('bg-slate-100', 'dark:bg-slate-800');
    
    activeIcon.classList.remove('text-slate-500', 'dark:text-slate-500');
    activeIcon.classList.add('text-white');

    activeH4.classList.add('group-hover:text-white');
    activeH4.classList.remove('group-hover:text-brand-600');
}
</script>
