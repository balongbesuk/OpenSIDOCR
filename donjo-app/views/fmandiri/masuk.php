<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>
        <?= $this->setting->login_title . ' ' . ucwords($this->setting->sebutan_desa) . (($header['nama_desa']) ? ' ' . $header['nama_desa'] : '') . get_dynamic_title_page_from_path() ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <script src="<?= asset('bootstrap/js/jquery.min.js') ?>"></script>
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            900: '#14532d',
                        },
                    }
                }
            }
        }
    </script>

    <link rel="shortcut icon" href="<?= favico_desa() ?>" />
    
    <!-- Legacy Assets Compatibility -->
    <link rel="stylesheet" href="<?= asset('bootstrap/css/bootstrap-datetimepicker.min.css') ?>">
    <?php if ($cek_anjungan) : ?>
        <link rel="stylesheet" href="<?= asset('css/keyboard.min.css') ?>">
        <link rel="stylesheet" href="<?= asset('front/css/mandiri-keyboard.css') ?>">
    <?php endif; ?>
    <?php if (cek_koneksi_internet()): ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css">
    <?php endif ?>

    <script src="<?= asset('bootstrap/js/jquery.min.js') ?>"></script>
    <?php $this->load->view('head_tags'); ?>

    <style type="text/css">
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
        }
        .mandiri-gradient {
            background: linear-gradient(135deg, rgba(20, 83, 45, 0.95) 0%, rgba(22, 163, 74, 0.8) 100%);
        }
        .input-premium {
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-premium:focus {
            background: white;
            border-color: #22c55e;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
            outline: none;
        }
        .btn-mandiri {
            background: linear-gradient(135deg, #16a34a 0%, #14532d 100%);
            box-shadow: 0 10px 15px -3px rgba(22, 163, 74, 0.3);
            transition: all 0.3s ease;
        }
        .btn-mandiri:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(22, 163, 74, 0.4);
            filter: brightness(1.1);
        }
        .panel-left-bg {
            background: url('<?= default_file(LATAR_LOGIN . $this->setting->latar_login_mandiri, DEFAULT_LATAR_KEHADIRAN) ?>') no-repeat center center;
            background-size: cover;
        }
        #countdown {
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { color: #ef4444; }
            50% { color: #b91c1c; }
            100% { color: #ef4444; }
        }
        /* Override for keyboard to not mess up Tailwind layout */
        .ui-keyboard { z-index: 10000; }

        /* PREMIUM MODAL OVERRIDE (For Cookie Consent & Warnings) */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            z-index: 10000;
            backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
        }
        .modal.in, .modal.show {
            display: flex !important;
        }
        .modal-dialog {
            width: 100%;
            max-width: 500px;
            margin: 20px;
            animation: modal-pop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes modal-pop {
            0% { opacity: 0; transform: scale(0.9) translateY(20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-content {
            background: white;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .modal-header {
            padding: 2rem 2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-title {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 800 !important;
            font-size: 1.25rem !important;
            color: #0f172a !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .modal-title i {
            color: #ef4444;
        }
        .modal-body {
            padding: 0 2rem 2rem;
            font-size: 1rem;
            line-height: 1.6;
            color: #475569;
        }
        .modal-body h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 1rem;
            display: block;
        }
        .modal-footer {
            padding: 1.5rem 2rem;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
        }
        .modal-footer .row {
            display: flex !important;
            gap: 1rem !important;
            justify-content: flex-end !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .close {
            background: #f1f5f9;
            border: none;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748b;
            transition: all 0.3s;
            font-size: 1.5rem;
            line-height: 1;
            padding-bottom: 0.25rem;
        }
        .close:hover {
            background: #fee2e2;
            color: #ef4444;
            transform: rotate(90deg);
        }
        /* Buttons inside modals */
        .modal-footer button, .modal-footer .btn {
            padding: 0.75rem 1.5rem !important;
            border-radius: 1rem !important;
            font-size: 0.875rem !important;
            font-weight: 700 !important;
            font-family: 'Inter', sans-serif !important;
            transition: all 0.3s !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            cursor: pointer !important;
            border: none !important;
            margin: 0 !important;
        }
        .btn-warning {
            background: #fefce8 !important;
            color: #854d0e !important;
            border: 1px solid #fef08a !important;
        }
        .btn-warning:hover {
            background: #fef9c3 !important;
        }
        .btn-danger, .btn-primary {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%) !important;
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2) !important;
        }
        .btn-danger:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(239, 68, 68, 0.3) !important;
        }
    </style>

    </style>
</head>

<body class="min-h-screen bg-white">
    <!-- Required element for original OpenSID id_browser.js to prevent crash -->
    <div id="pengunjung" class="hidden" style="display: none;"></div>

    <!-- Wrapper utama untuk mencegah elemen cookie merusak layout flex -->
    <div class="min-h-screen flex overflow-hidden">
        <!-- PANEL KIRI: Visual & Info Digital Desa -->
        <div class="hidden lg:flex lg:w-3/5 xl:w-[65%] relative overflow-hidden panel-left-bg">
            <div class="absolute inset-0 mandiri-gradient"></div>
            
            <div class="relative z-10 flex flex-col justify-between p-16 w-full text-white">
                <div class="flex items-center space-x-5">
                    <img src="<?= gambar_desa($header['logo']) ?>" alt="Logo" class="h-20 w-auto drop-shadow-2xl" />
                    <div>
                        <h2 class="font-display font-bold text-2xl tracking-tight leading-none uppercase">
                            LAYANAN MANDIRI
                        </h2>
                        <p class="text-white/70 text-base font-medium mt-1">
                            <?= ucwords($this->setting->sebutan_desa) ?> <?= $header['nama_desa'] ?>
                        </p>
                    </div>
                </div>

                <div class="max-w-2xl">
                    <h1 class="font-display text-6xl xl:text-7xl font-extrabold leading-[1.1] mb-8">
                        Akses Layanan <span class="text-green-200">Dalam Genggaman.</span>
                    </h1>
                    <div class="space-y-6 text-green-50/90 text-lg xl:text-xl font-medium leading-relaxed max-w-xl">
                        <p>Urus surat keterangan, cek bantuan sosial, dan pantau data kependudukan Anda secara mandiri dengan cepat dan aman.</p>
                        
                        <div class="grid grid-cols-2 gap-6 pt-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                                    <i class="fa-solid fa-file-signature text-green-300"></i>
                                </div>
                                <span class="text-sm">Persuratan Online</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                                    <i class="fa-solid fa-hand-holding-heart text-green-300"></i>
                                </div>
                                <span class="text-sm">Info Bantuan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col space-y-4">
                    <div class="flex items-center space-x-8">
                        <div class="flex flex-col">
                            <span class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-bold mb-2">Sistem Informasi</span>
                            <div class="flex items-center space-x-3">
                                <span class="font-display font-black text-2xl tracking-tighter">OpenSID</span>
                                <span class="bg-white/10 px-2 py-0.5 rounded text-[10px] font-bold"><?= AmbilVersi() ?></span>
                            </div>
                        </div>
                        <div class="h-10 w-px bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-bold mb-2">Identitas Akses</span>
                            <span class="text-xs font-mono bg-black/20 px-3 py-1 rounded-lg">IP: <?= $this->input->ip_address() ?></span>
                        </div>
                    </div>
                    <p class="text-white/40 text-[10px] italic">Silakan hubungi operator desa untuk mendapatkan kode PIN anda.</p>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-green-400/20 rounded-full blur-[100px]"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-green-600/20 rounded-full blur-[100px]"></div>
        </div>

        <!-- PANEL KANAN: Form Masuk Mandiri -->
        <div class="w-full lg:w-2/5 xl:w-[35%] bg-white flex items-center justify-center p-8 md:p-16 xl:p-20 relative overflow-y-auto">
            <!-- Floating Navigation -->
            <div class="absolute top-0 left-0 right-0 p-8 flex justify-between items-center z-20 pointer-events-none">
                <a href="<?= site_url() ?>" class="pointer-events-auto group flex items-center space-x-3 text-slate-400 hover:text-green-600 transition-all duration-300">
                    <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:bg-white group-hover:border-green-400 group-hover:shadow-lg group-hover:shadow-green-500/10 transition-all duration-500">
                        <i class="fa-solid fa-arrow-left text-[10px] group-hover:-translate-x-1 transition-transform"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] leading-none">Ke Beranda</span>
                        <span class="text-[8px] font-bold text-slate-300 uppercase tracking-widest mt-1 group-hover:text-green-300 transition-colors">Situs Desa</span>
                    </div>
                </a>
            </div>

            <div class="w-full max-w-md my-auto">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12 text-center">
                    <img src="<?= gambar_desa($header['logo']) ?>" alt="Logo" class="h-16 w-auto mx-auto mb-4" />
                    <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Layanan Mandiri</h1>
                    <p class="text-slate-500 text-sm font-medium"><?= $header['nama_desa'] ?></p>
                </div>

                <div class="mb-10">
                    <h2 class="font-display text-3xl font-extrabold text-slate-900 mb-2">Masuk Warga</h2>
                    <p class="text-slate-500 font-medium">Gunakan NIK dan PIN Anda untuk masuk.</p>
                </div>

                <?php if ($this->session->mandiri_wait == 1) : ?>
                    <div class="text-center py-12 bg-red-50 rounded-[2.5rem] border border-red-100 px-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 text-red-600 rounded-full mb-6">
                            <i class="fa-solid fa-clock-rotate-left text-4xl"></i>
                        </div>
                        <h3 class="font-display font-bold text-xl text-red-800 mb-2">Terlalu Banyak Percobaan</h3>
                        <p id="countdown" class="text-red-600 font-bold uppercase tracking-widest text-xs"></p>
                    </div>
                <?php else : ?>
                    <?php if ($this->session->mandiri_try < 4) : ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-start space-x-3">
                            <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                            <div class="text-red-700 text-sm font-bold">
                                NIK atau PIN salah.
                                <span class="block text-xs font-medium mt-1">Kesempatan mencoba <?= ($this->session->mandiri_try - 1) ?> kali lagi.</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->aktif == true) : ?>
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-start space-x-3">
                            <i class="fa-solid fa-circle-info text-blue-500 mt-0.5"></i>
                            <p class="text-blue-700 text-sm font-medium leading-relaxed">Akun Anda sedang menunggu verifikasi dari operator desa.</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->daftar_verifikasi) : ?>
                        <div class="bg-slate-50 rounded-[2.5rem] p-8 border border-slate-100">
                            <?php $this->load->view(MANDIRI . '/pendaftaran-verifikasi') ?>
                        </div>
                    <?php elseif ($this->session->daftar) : ?>
                        <form id="validasi" action="<?= $form_action; ?>" method="post" enctype="multipart/form-data">
                            <?php $this->load->view(MANDIRI . '/pendaftaran') ?>
                        </form>
                    <?php else : ?>
                        <form id="validasi" action="<?= $form_action; ?>" method="post" class="space-y-6">
                            <?php if (! $this->session->login_ektp) : ?>
                                <div class="space-y-5">
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700 ml-1">NIK (Nomor Induk Kependudukan)</label>
                                        <div class="relative group">
                                            <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                                            <input type="text" autocomplete="off" name="nik" placeholder="16 digit NIK"
                                                class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber') ?>">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700 ml-1">PIN Layanan</label>
                                        <div class="relative group">
                                            <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                                            <input type="password" autocomplete="off" name="pin" id="pin" placeholder="Kode PIN Anda"
                                                class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber') ?>">
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 px-1">
                                        <label class="flex items-center cursor-pointer group select-none">
                                            <input type="checkbox" id="checkbox" class="sr-only">
                                            <div class="w-10 h-6 bg-slate-200 rounded-full p-1 transition-colors group-hover:bg-slate-300 peer-checked:bg-green-600 toggle-bg relative">
                                                <div class="w-4 h-4 bg-white rounded-full shadow-sm transition-transform toggle-dot"></div>
                                            </div>
                                            <span class="ml-2.5 text-xs font-bold text-slate-600 group-hover:text-slate-900 transition-colors whitespace-nowrap">Lihat PIN</span>
                                        </label>
                                        
                                        <a href="<?= site_url('layanan-mandiri/lupa-pin') ?>" class="text-xs font-bold text-green-700 hover:text-green-800 transition-all whitespace-nowrap">
                                            Lupa PIN?
                                        </a>
                                    </div>
                                </div>

                                <div class="space-y-4 pt-4">
                                    <button type="submit" class="btn-mandiri w-full h-16 rounded-2xl text-white font-display font-extrabold tracking-wide text-sm flex items-center justify-center space-x-3">
                                        <span>MASUK LAYANAN</span>
                                        <i class="fa-solid fa-right-to-bracket text-lg"></i>
                                    </button>

                                    <div class="grid grid-cols-2 gap-4">
                                        <a href="<?= site_url('layanan-mandiri/masuk-ektp') ?>" class="h-14 flex items-center justify-center space-x-2 border-2 border-slate-100 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-credit-card"></i>
                                            <span>E-KTP</span>
                                        </a>
                                        <?php if ($this->setting->tampilkan_pendaftaran) : ?>
                                            <a href="<?= site_url('layanan-mandiri/daftar') ?>" class="h-14 flex items-center justify-center space-x-2 border-2 border-slate-100 rounded-2xl text-slate-600 text-xs font-bold hover:bg-slate-50 transition-colors">
                                                <i class="fa-solid fa-user-plus"></i>
                                                <span>DAFTAR</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <!-- E-KTP SCAN VIEW -->
                                <div class="text-center py-8">
                                    <div class="mb-8 relative inline-block">
                                        <div class="absolute inset-0 bg-green-500/10 rounded-full animate-ping"></div>
                                        <div class="relative w-32 h-32 bg-green-50 rounded-full flex items-center justify-center border-2 border-green-100">
                                            <i class="fa-solid fa-id-card text-5xl text-green-600"></i>
                                        </div>
                                    </div>
                                    
                                    <h3 class="font-display font-bold text-xl text-slate-900 mb-2">Pemindaian E-KTP</h3>
                                    <p class="text-slate-500 mb-8 max-w-[240px] mx-auto text-sm leading-relaxed">
                                        <?php if ($cek_anjungan) : ?>
                                            Silakan tempelkan e-KTP Anda pada Card Reader yang tersedia.
                                        <?php else : ?>
                                            Arahkan e-KTP Anda ke kamera atau masukkan PIN untuk validasi.
                                        <?php endif; ?>
                                    </p>

                                    <div class="space-y-4">
                                        <div class="form-group" style="<?= jecho($cek_anjungan == 0 || ENVIRONMENT == 'development', false, 'width: 0; height:0; opacity:0; overflow: hidden;') ?>">
                                            <input name="tag" id="tag" autocomplete="off" class="form-control required number" type="password" onkeypress="if (event.keyCode == 13){$('#'+'validasi').attr('action', '<?= $form_action; ?>');$('#'+'validasi').submit();}">
                                        </div>

                                        <?php if (! $cek_anjungan) : ?>
                                            <div class="relative group">
                                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                                                <input type="password" class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required number" name="pin" placeholder="Konfirmasi PIN" id="pin" autocomplete="off">
                                            </div>
                                            <button type="submit" class="btn-mandiri w-full h-16 rounded-2xl text-white font-display font-extrabold tracking-wide text-sm uppercase">Verifikasi Masuk</button>
                                        <?php endif; ?>

                                        <div class="pt-6 border-t border-slate-100 mt-8">
                                            <a href="<?= site_url('layanan-mandiri/masuk') ?>" class="inline-flex items-center space-x-2 px-6 py-3 rounded-xl bg-slate-50 text-slate-500 hover:text-green-600 hover:bg-green-50 transition-all duration-300 group">
                                                <i class="fa-solid fa-keyboard text-xs group-hover:-translate-y-0.5 transition-transform"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Gunakan NIK & PIN</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($cek_anjungan['tipe'] == 1): ?>
                                <a href="<?= site_url('layanan-mandiri') ?>" class="flex items-center justify-center space-x-2 w-full py-4 text-slate-400 hover:text-slate-600 transition-colors">
                                    <i class="fa-solid fa-display text-sm"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">Balik Ke Mode Anjungan</span>
                                </a>
                            <?php endif ?>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Footer Small -->
                <div class="mt-16 text-center border-t border-slate-100 pt-8 opacity-60">
                    <p class="text-slate-400 text-[10px] tracking-widest uppercase mb-1 font-bold">Layanan Digital Desa</p>
                    <div class="flex items-center justify-center space-x-2">
                        <span class="font-display font-black text-slate-900 text-lg tracking-tighter">OpenSID</span>
                        <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-bold"><?= AmbilVersi() ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Legacy Scripts & Logic -->
    <?php $this->load->view('global/konfirmasi_cookie', ['cookie_name' => 'pengunjung']); ?>
    <?php $this->load->view('global/aktifkan_cookie'); ?>

    <script src="<?= asset('bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/moment.min.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/moment-timezone.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/moment-timezone-with-data.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/bootstrap-datetimepicker.min.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/id.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/jquery.slimscroll.min.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/fastclick.js') ?>"></script>
    <script src="<?= asset('js/adminlte.min.js') ?>"></script>
    <script src="<?= asset('js/jquery.validate.min.js') ?>"></script>
    <script src="<?= asset('js/validasi.js') ?>"></script>
    <script src="<?= asset('js/localization/messages_id.js') ?>"></script>

    <?php if (cek_koneksi_internet()): ?>
        <script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
    <?php endif ?>

    <?php if ($cek_anjungan) : ?>
        <script src="<?= asset('js/jquery.keyboard.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.mousewheel.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.keyboard.extension-all.min.js') ?>"></script>
        <script src="<?= asset('front/js/mandiri-keyboard.js') ?>"></script>
    <?php endif; ?>
    <script src="<?= asset('js/id_browser.js') ?>"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Mocking Bootstrap modal if not loaded
            if (typeof $.fn.modal !== 'function') {
                $.fn.modal = function(action) {
                    if (action === 'show') {
                        this.addClass('show');
                        this.trigger('show.bs.modal');
                        $('body').addClass('modal-open');
                    }
                    if (action === 'hide') {
                        this.removeClass('show');
                        this.trigger('hide.bs.modal');
                        $('body').removeClass('modal-open');
                    }
                    return this;
                };
            }

            // Ensure buatPengunjungCookie is safe if redefined
            var originalBuatPengunjungCookie = window.buatPengunjungCookie;
            window.buatPengunjungCookie = function(name) {
                if ($('#pengunjung').length === 0) {
                    $('body').append('<div id="pengunjung" class="hidden" style="display:none"></div>');
                }
                if (typeof originalBuatPengunjungCookie === 'function') {
                    originalBuatPengunjungCookie(name);
                } else {
                    // Fallback
                    var date = new Date();
                    date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
                    document.cookie = "pengunjung=set; expires=" + date.toUTCString() + "; path=/";
                    $('#konfirmasi-cookie').modal('hide');
                    location.reload();
                }
            };

            // Close modal events
            $('.modal .close, .modal [data-dismiss="modal"]').on('click', function() {
                $(this).closest('.modal').modal('hide');
            });
            
            // Re-trigger cookie check if needed
            if (typeof checkCookie === 'function') checkCookie();

            var pass = $("#pin");
            var ektp = '<?= $this->session->login_ektp ?>';
            var anjungan = '<?= $cek_anjungan ?>';

            $('#checkbox').change(function() {
                const dot = $(".toggle-dot");
                const bg = $(".toggle-bg");
                if ($(this).is(':checked')) {
                    pass.attr('type', 'text');
                    dot.addClass('translate-x-4');
                    bg.addClass('bg-green-600').removeClass('bg-slate-200');
                } else {
                    pass.attr('type', 'password');
                    dot.removeClass('translate-x-4');
                    bg.removeClass('bg-green-600').addClass('bg-slate-200');
                }
            });

            if (ektp) {
                if (anjungan) $('#tag').focus();
                else $('#pin').focus();
            }

            $('#daftar_tgl_lahir').datetimepicker({
                format: 'DD-MM-YYYY',
                locale: 'id',
                maxDate: 'now',
            });

            if ($('#countdown').length) {
                start_countdown();
            }

            window.setTimeout(function() {
                $(".callout").fadeTo(500, 0).slideUp(500);
            }, 5000);
        });

        function start_countdown() {
            var times = eval(<?= json_encode($this->session->mandiri_timeout, JSON_THROW_ON_ERROR) ?>) - eval(<?= json_encode(time(), JSON_THROW_ON_ERROR) ?>);
            var menit = Math.floor(times / 60);
            var detik = times % 60;

            timer = setInterval(function() {
                detik--;
                if (detik <= 0 && menit >= 1) {
                    detik = 60;
                    menit--;
                }
                if (menit <= 0 && detik <= 0) {
                    clearInterval(timer);
                    location.reload();
                } else {
                    document.getElementById("countdown").innerHTML = "Gagal 3 kali, coba kembali dlm " + menit + "m " + (detik < 10 ? '0' + detik : detik) + "s";
                }
            }, 1000);
        }
    </script>
</body>

</html>