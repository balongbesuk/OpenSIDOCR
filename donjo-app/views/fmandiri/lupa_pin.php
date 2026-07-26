<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <script src="<?= asset('bootstrap/js/jquery.min.js') ?>"></script>
    <title><?= $this->setting->login_title . ' ' . ucwords($this->setting->sebutan_desa) . (($header['nama_desa']) ? ' ' . $header['nama_desa'] : '') . get_dynamic_title_page_from_path(); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
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
    <?php if ($cek_anjungan) : ?>
        <link rel="stylesheet" href="<?= asset('css/keyboard.min.css') ?>">
        <link rel="stylesheet" href="<?= asset('front/css/mandiri-keyboard.css') ?>">
    <?php endif; ?>

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
            background: url('<?= default_file(LATAR_KEHADIRAN, DEFAULT_LATAR_KEHADIRAN) ?>') no-repeat center center;
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
        .btn-outline-green {
            border: 2px solid #16a34a;
            color: #16a34a;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-outline-green:hover {
            background: #f0fdf4;
            transform: translateY(-1px);
        }
    </style>
</head>

<body class="min-h-screen bg-white">
    <!-- Required element for original OpenSID id_browser.js to prevent crash -->
    <div id="pengunjung" class="hidden" style="display: none;"></div>

    <!-- Wrapper utama untuk memastikan layout penuh layar -->
    <div class="min-h-screen flex overflow-hidden">
    <!-- PANEL KIRI: Visual & Branding (Shared) -->
    <div class="hidden lg:flex lg:w-3/5 xl:w-[65%] relative overflow-hidden panel-left-bg">
        <div class="absolute inset-0 mandiri-gradient"></div>
        
        <div class="relative z-10 flex flex-col justify-between p-16 w-full text-white">
            <div class="flex items-center space-x-5">
                <img src="<?= gambar_desa($header['logo']) ?>" alt="Logo" class="h-20 w-auto drop-shadow-2xl" />
                <div>
                    <h2 class="font-display font-bold text-2xl tracking-tight leading-none uppercase">
                        LAYANAN MANDIRI
                    </h2>
                    <p class="text-white/70 text-base font-medium mt-1">Layanan Pemulihan PIN</p>
                </div>
            </div>

            <div>
                <h1 class="font-display text-6xl xl:text-7xl font-extrabold leading-[1.1] mb-6">
                    Aman & <span class="text-green-200">Terlindungi.</span>
                </h1>
                <p class="text-green-50/80 text-lg xl:text-xl font-medium leading-relaxed max-w-xl">
                    Sistem pemulihan otomatis kami akan mengirimkan PIN baru melalui Telegram atau Email terdaftar Anda. Pastikan data akun Anda selalu diperbarui.
                </p>
            </div>

            <div class="flex items-center space-x-8">
                <div class="flex flex-col">
                    <span class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-bold mb-2">Didukung Oleh</span>
                    <div class="flex items-center space-x-3 text-white/90 transition-colors">
                        <span class="font-display font-black text-2xl tracking-tighter">OpenSID</span>
                        <span class="bg-white/10 px-2 py-0.5 rounded text-[10px] font-bold"><?= AmbilVersi() ?></span>
                    </div>
                </div>
                <div class="h-10 w-px bg-white/10"></div>
                <div class="flex flex-col">
                    <span class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-bold mb-2">Identitas Akses</span>
                    <span class="text-xs font-mono bg-black/20 px-3 py-1 rounded-lg">IP: <?= (! $cek_anjungan) ? $this->input->ip_address() : $cek_anjungan['ip_address']; ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL KANAN: Form Pemulihan PIN -->
    <div class="w-full lg:w-2/5 xl:w-[35%] bg-white flex items-center justify-center p-8 md:p-16 xl:p-20 relative overflow-y-auto">
        <div class="w-full max-w-md">
            <div class="mb-10 lg:mb-12">
                <a href="<?= site_url('layanan-mandiri/masuk') ?>" class="inline-flex items-center text-green-700 font-bold text-xs uppercase tracking-widest mb-8 hover:text-green-800 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Masuk
                </a>
                <h2 class="font-display text-3xl font-extrabold text-slate-900 mb-2">Lupa PIN?</h2>
                <p class="text-slate-500 font-medium">Pulihkan akses Layanan Mandiri Anda.</p>
            </div>

            <form id="validasi" action="<?= $form_action; ?>" method="post" class="space-y-6">
                <?php if ($this->session->mandiri_wait == 1) : ?>
                    <div class="text-center py-12 bg-red-50 rounded-[2.5rem] border border-red-100 px-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 text-red-600 rounded-full mb-6">
                            <i class="fa-solid fa-clock-rotate-left text-4xl"></i>
                        </div>
                        <h3 class="font-display font-bold text-xl text-red-800 mb-2">Tunggu Sejenak</h3>
                        <p id="countdown" class="text-red-600 font-bold uppercase tracking-widest text-xs"></p>
                    </div>
                <?php else : ?>
                    <?php if ($lupa_pin = $this->session->flashdata('lupa_pin')) : ?>
                        <div class="mb-8 p-6 bg-green-50 border border-green-100 rounded-[2rem] flex items-start space-x-4">
                            <i class="fa-solid fa-circle-check text-green-600 text-xl mt-1"></i>
                            <p class="text-green-800 text-sm font-medium leading-relaxed"><?= $lupa_pin['pesan']; ?></p>
                        </div>
                    <?php else : ?>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">NIK (Nomor Induk Kependudukan)</label>
                                <div class="relative group">
                                    <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                                    <input type="text" autocomplete="off" name="nik" placeholder="16 digit NIK" maxlength="16"
                                        class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required nik <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>">
                                </div>
                            </div>

                            <div class="space-y-4 pt-4">
                                <p class="text-[10px] text-slate-400 uppercase tracking-[0.2em] font-bold text-center mb-6">Metode Pengiriman</p>
                                
                                <button type="submit" name="send" value="telegram" class="btn-mandiri w-full h-16 rounded-2xl text-white font-display font-extrabold tracking-wide text-sm flex items-center justify-center space-x-3 mb-4">
                                    <i class="fa-brands fa-telegram text-xl"></i>
                                    <span>KIRIM KE TELEGRAM</span>
                                </button>
                                
                                <button type="submit" name="send" value="email" class="w-full h-16 rounded-2xl bg-white border-2 border-slate-100 text-slate-700 font-display font-bold tracking-wide text-sm flex items-center justify-center space-x-3 hover:bg-slate-50 hover:border-slate-200 transition-all">
                                    <i class="fa-solid fa-envelope text-lg"></i>
                                    <span>KIRIM KE EMAIL</span>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="pt-8 grid grid-cols-2 gap-4 border-t border-slate-100">
                    <a href="<?= site_url('layanan-mandiri/masuk-ektp') ?>" class="h-12 border-2 border-slate-100 rounded-xl flex items-center justify-center space-x-2 text-slate-500 text-[10px] font-bold uppercase transition-all hover:bg-slate-50">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>E-KTP</span>
                    </a>
                    <a href="<?= site_url('layanan-mandiri/masuk') ?>" class="h-12 border-2 border-slate-100 rounded-xl flex items-center justify-center space-x-2 text-slate-500 text-[10px] font-bold uppercase transition-all hover:bg-slate-50">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>MASUK</span>
                    </a>
                </div>
            </form>

            <div class="mt-16 text-center opacity-60">
                <p class="text-slate-400 text-[10px] tracking-widest uppercase mb-1 font-bold">Layanan Digital Desa</p>
                <div class="flex items-center justify-center space-x-2">
                    <span class="font-display font-black text-slate-900 text-lg tracking-tighter">OpenSID</span>
                    <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-bold"><?= AmbilVersi() ?></span>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Legacy Scripts Compatibility -->
    <script src="<?= asset('bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/jquery.slimscroll.min.js') ?>"></script>
    <script src="<?= asset('bootstrap/js/fastclick.js') ?>"></script>
    <script src="<?= asset('js/adminlte.min.js') ?>"></script>
    <script src="<?= asset('js/id_browser.js') ?>"></script>
    <script src="<?= asset('js/jquery.validate.min.js') ?>"></script>
    <script src="<?= asset('js/validasi.js') ?>"></script>
    <script src="<?= asset('js/localization/messages_id.js') ?>"></script>

    <?php if ($cek_anjungan) : ?>
        <script src="<?= asset('js/jquery.keyboard.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.mousewheel.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.keyboard.extension-all.min.js') ?>"></script>
        <script src="<?= asset('front/js/mandiri-keyboard.js') ?>"></script>
    <?php endif; ?>

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

            if ($('#countdown').length) {
                start_countdown();
            }
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500);
            }, 5000);

            // Re-trigger cookie check if needed
            if (typeof checkCookie === 'function') checkCookie();
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
                    document.getElementById("countdown").innerHTML = "Coba kembali dlm " + menit + "m " + (detik < 10 ? '0' + detik : detik) + "s";
                }
            }, 1000);
        }
    </script>
</body>

</html>