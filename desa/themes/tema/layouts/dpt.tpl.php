<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-200 selection:bg-brand-100 selection:text-brand-900 overflow-x-hidden transition-colors duration-500">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <div class="h-24 md:h-32"></div>

    <main class="min-h-screen">
        <section class="py-12 md:py-20 bg-slate-50/50 dark:bg-slate-950">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    
                    <!-- [STYLES TO CLEAN UP OPENSID DEFAULTS] -->
                    <style>
                        .dpt-container .artikel-judul, 
                        .dpt-container .text-title, 
                        .dpt-container br { display: none !important; }
                        
                        .dpt-table table { width: 100% !important; border-collapse: separate !important; border-spacing: 0 !important; border: none !important; margin: 0 !important; }
                        .dpt-table thead th { 
                            background: #f8fafc !important; 
                            color: #64748b !important; 
                            font-family: 'Inter', sans-serif !important; 
                            font-weight: 800 !important; 
                            text-transform: uppercase !important; 
                            letter-spacing: 0.15em !important; 
                            padding: 1.5rem 1rem !important; 
                            border-bottom: 2px solid #f1f5f9 !important; 
                            text-align: center !important; 
                            font-size: 10px !important; 
                        }
                        .dpt-table td { 
                            padding: 1.5rem 1rem !important; 
                            border-bottom: 1px solid #f8fafc !important; 
                            vertical-align: middle !important; 
                            color: #334155 !important; 
                            font-weight: 500 !important; 
                            font-size: 13px !important; 
                            transition: all 0.2s;
                        }
                        .dpt-table tr:hover td { background: #fbfcfe !important; color: #2563eb !important; }
                        .dpt-table tfoot th { 
                            background: #f8fafc !important; 
                            padding: 1.5rem 1rem !important; 
                            font-weight: 900 !important; 
                            color: #0f172a !important; 
                            border-top: 2px solid #f1f5f9 !important;
                            text-transform: uppercase;
                            letter-spacing: 0.1em;
                            font-size: 11px;
                        }

                        /* Dark Mode Support for DPT Table */
                        .dark .dpt-table thead th { background: #1e293b !important; color: #94a3b8 !important; border-bottom-color: #334155 !important; }
                        .dark .dpt-table td { color: #cbd5e1 !important; border-bottom-color: #1e293b !important; }
                        .dark .dpt-table tr:hover td { background: #1e293b50 !important; color: #60a5fa !important; }
                        .dark .dpt-table tfoot th { background: #1e293b !important; color: #f8fafc !important; border-top-color: #334155 !important; }
                    </style>

                    <!-- [NAVIGATION BREADCRUMB] -->
                    <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-10">
                        <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                        <a href="<?= site_url('data-statistik') ?>" class="hover:text-brand-600 transition-colors">Statistik Desa</a>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                        <span class="text-brand-600 dark:text-brand-400 font-extrabold">DPT (Calon Pemilih)</span>
                    </nav>

                    <!-- [HEADER] -->
                    <header class="mb-14 flex flex-col md:flex-row md:items-end justify-between gap-10 relative">
                        <div class="max-w-3xl">
                            <div class="flex items-center gap-3 mb-5">
                                <span class="w-12 h-1 bg-brand-600 rounded-full"></span>
                                <span class="text-brand-600 font-black tracking-[0.3em] uppercase text-[10px]">Transparansi Demokrasi</span>
                            </div>
                            <h1 class="font-display font-[900] text-4xl md:text-6xl text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-2">
                                Daftar <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">Calon Pemilih</span>.
                            </h1>
                            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg max-w-xl">Informasi rincian daftar pemilih tetap desa berdasarkan wilayah dusun dan RW secara real-time.</p>
                        </div>
                        <div class="relative z-20">
                            <button onclick="window.print()" class="h-16 px-8 rounded-3xl bg-slate-900 dark:bg-brand-600 text-white flex items-center justify-center gap-4 hover:bg-brand-600 dark:hover:bg-brand-500 transition-all shadow-2xl shadow-slate-900/10 active:scale-95">
                                <i class="fa-solid fa-print text-lg"></i>
                                <span class="font-black text-xs uppercase tracking-widest whitespace-nowrap">Cetak Laporan</span>
                            </button>
                        </div>
                    </header>

                    <!-- [DATA TABLE] -->
                    <div class="p-4 md:p-10 rounded-[3.5rem] bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-2xl shadow-slate-200/40 dark:shadow-none overflow-hidden relative group">
                        <div class="absolute -right-32 -top-32 w-96 h-96 bg-brand-600/5 dark:bg-brand-600/10 rounded-full blur-[100px] pointer-events-none"></div>
                        <div class="dpt-container dpt-table relative z-10">
                            <?php $this->load->view($folder_themes.'/partials/statistik/dpt.php'); ?>
                        </div>
                    </div>

                    <!-- [INFO CARD] -->
                    <div class="mt-20 p-12 md:p-20 rounded-[4.5rem] bg-slate-900 border-none relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-12 group">
                        <div class="absolute right-0 bottom-0 w-[500px] h-[500px] bg-brand-600/10 rounded-full blur-[120px]"></div>
                        
                        <div class="relative z-10 flex flex-col md:flex-row gap-10 items-center text-center md:text-left">
                            <div class="w-24 h-24 rounded-3xl bg-white/10 backdrop-blur-3xl border border-white/20 flex items-center justify-center text-4xl group-hover:rotate-12 transition-all duration-500">
                                <i class="fa-solid fa-check-to-slot text-brand-400"></i>
                            </div>
                            <div class="max-w-xl">
                                <h4 class="font-display font-black text-3xl text-white mb-4 leading-none tracking-tight">Gunakan Hak Pilih Anda!</h4>
                                <p class="text-slate-400 font-medium leading-relaxed">
                                    Data ini merupakan daftar warga yang memiliki hak pilih pada pemilihan mendatang. Pastikan nama Anda terdaftar untuk dapat berpartisipasi dalam menentukan masa depan desa.
                                </p>
                            </div>
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-center gap-4 text-xs font-black uppercase tracking-widest text-brand-400">
                                <span class="w-8 h-px bg-brand-600"></span>
                                Verified Data
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>

    <!-- AOS (Animate On Scroll) Logic -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>
