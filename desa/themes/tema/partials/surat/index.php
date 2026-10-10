<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Verifikasi Surat Digital</title>
    
    <!-- Link Assets from Theme -->
    <link rel="stylesheet" href="<?= base_url($folder_themes . '/assets/css/all.min.css') ?>">
    <script src="<?= base_url($folder_themes . '/assets/js/tailwind.js') ?>"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&family=Inter:wght@400;500;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 md:p-12">
    
    <div class="w-full max-w-2xl bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative">
        <!-- Floating Decor -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-50"></div>
        
        <div class="p-10 md:p-16 relative z-10">
            <!-- Header Logo -->
            <div class="flex flex-col md:flex-row items-center gap-8 mb-12 border-b border-slate-50 pb-10">
                <img class="w-20 h-auto object-contain drop-shadow-md" src="<?= gambar_desa($config['logo']); ?>" alt="logo-desa">
                <div class="text-center md:text-left">
                    <h5 class="font-display font-black text-slate-900 text-xl leading-tight uppercase tracking-tight">
                        Pemerintah <?= ucwords($this->setting->sebutan_kabupaten . ' ' . $config['nama_kabupaten']); ?>
                    </h5>
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">
                        <?= ucwords($this->setting->sebutan_kecamatan . ' ' . $config['nama_kecamatan']); ?> • <?= ucwords($this->setting->sebutan_desa . ' ' . $config['nama_desa']); ?>
                    </p>
                    <p class="text-slate-400 font-medium text-[10px] mt-2 italic"><?= ucwords($config['alamat_kantor']); ?></p>
                </div>
            </div>

            <!-- Content Area -->
            <div class="space-y-10">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-6 bg-brand-600 rounded-full"></div>
                    <h2 class="font-display font-[900] text-xl text-slate-900 uppercase tracking-widest">Detail Verifikasi</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 bg-slate-50/50 rounded-[2.5rem] p-8 border border-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomor Surat</span>
                        <span class="font-bold text-slate-900 text-sm"><?= $surat->nomor_surat; ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 pt-4 border-t border-white">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Publish</span>
                        <span class="font-bold text-slate-900 text-sm"><?= tgl_indo($surat->tanggal); ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 pt-4 border-t border-white">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Perihal</span>
                        <span class="font-black text-brand-600 text-sm uppercase"><?= $surat->perihal; ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 pt-4 border-t border-white">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Atas Nama</span>
                        <span class="font-bold text-slate-900 text-lg"><?= $surat->nama_penduduk ?? $surat->nama_non_warga; ?></span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-6 pt-10 border-t border-slate-100">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl shadow-sm border border-emerald-100 shrink-0">
                        <i class="fa-solid fa-file-circle-check"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-black text-emerald-600 text-lg leading-tight mb-1">Arsip Valid & Terdaftar</h4>
                        <p class="text-slate-400 text-xs font-medium">Dokumen ini secara resmi tercatat dalam basis data pelayanan desa.</p>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50 text-center">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em]">Digital Signature Verification System</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>