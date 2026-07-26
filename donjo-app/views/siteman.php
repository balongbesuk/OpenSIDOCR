<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $this->setting->login_title . ' ' . ucwords($this->setting->sebutan_desa) . (($header['nama_desa']) ? ' ' . $header['nama_desa'] : '') . get_dynamic_title_page_from_path() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    
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
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        },
                    }
                }
            }
        }
    </script>

    <link rel="shortcut icon" href="<?= favico_desa() ?>" />
    
    <script src="<?= asset('bootstrap/js/jquery.min.js') ?>"></script>

    <!-- CSRF Protection Support -->
    <?php if ($this->config->config['csrf_protection']): ?>
        <script type="text/javascript">
            var csrfParam = '<?= $this->security->get_csrf_token_name() ?>';
            var getCsrfToken = () => document.cookie.match(new RegExp(csrfParam +'=(\\w+)'))[1]
        </script>
        <script src="<?= asset('js/anti-csrf.js') ?>"></script>
    <?php endif ?>

    <style type="text/css">
        body { font-family: 'Inter', sans-serif; background: #ffffff; }
        .login-gradient { background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(37, 99, 235, 0.8) 100%); }
        .input-premium {
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-premium:focus {
            background: white; border-color: #3b82f6; 
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); outline: none;
        }
        .btn-modern {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }
        .btn-modern:hover { transform: translateY(-2px); filter: brightness(1.1); }
        .panel-left-bg {
            background: url('<?= $latar_login ?>') no-repeat center center;
            background-size: cover;
        }
        #countdown { animation: pulse-red 2s infinite; }
        @keyframes pulse-red {
            0% { color: #ef4444; } 50% { color: #b91c1c; } 100% { color: #ef4444; }
        }
    </style>

    <script src="<?= asset('js/jquery.validate.min.js') ?>"></script>
    <script src="<?= asset('js/validasi.js') ?>"></script>
    <script src="<?= asset('js/localization/messages_id.js') ?>"></script>
</head>

<body class="min-h-screen flex overflow-hidden">
    <!-- PANEL KIRI: Visual & Branding (Desktop Only) -->
    <div class="hidden lg:flex lg:w-3/5 xl:w-[65%] relative overflow-hidden panel-left-bg">
        <div class="absolute inset-0 login-gradient"></div>
        <div class="relative z-10 flex flex-col justify-between p-16 w-full">
            <div class="flex items-center space-x-4">
                <img src="<?= gambar_desa($header['logo']) ?>" alt="Logo" class="h-16 w-auto drop-shadow-xl" />
                <div class="text-white">
                    <h2 class="font-display font-bold text-xl tracking-tight leading-none uppercase">
                        Portal Resmi <?= ucwords($this->setting->sebutan_desa) ?>
                    </h2>
                    <p class="text-white/70 text-sm font-medium">Kabupaten <?= $header['nama_kabupaten'] ?></p>
                </div>
            </div>

            <div class="max-w-2xl">
                <h1 class="font-display text-6xl xl:text-7xl font-extrabold text-white leading-[1.1] mb-6">
                    Selamat Datang di <span class="text-blue-200">Panel Administrasi.</span>
                </h1>
                <p class="text-blue-100/80 text-lg xl:text-xl font-medium leading-relaxed max-w-xl">
                    Kelola data kependudukan, transparansi dana, dan layanan publik desa dengan sistem yang modern, terintegrasi, dan mudah digunakan.
                </p>
            </div>

            <div class="flex items-center space-x-8">
                <div class="flex flex-col">
                    <span class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-bold mb-2">Didukung Oleh</span>
                    <a href="https://github.com/OpenSID/OpenSID" target="_blank" class="flex items-center space-x-2 text-white/90 hover:text-white transition-colors group">
                        <span class="font-display font-black text-2xl tracking-tighter">OpenSID</span>
                        <span class="bg-white/10 px-2 py-0.5 rounded text-[10px] font-bold group-hover:bg-white/20 transition-colors"><?= AmbilVersi() ?></span>
                    </a>
                </div>
                <div class="h-10 w-px bg-white/10"></div>
                <?php if (setting('tte')) : ?>
                    <div class="flex flex-col">
                        <span class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-bold mb-2">Keamanan Transaksi</span>
                        <img src="<?= $logo_bsre ?>" alt="BSRE" class="h-8 w-auto opacity-70 grayscale hover:grayscale-0 transition-all" />
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>

    <!-- PANEL KANAN: Form Login -->
    <div class="w-full lg:w-2/5 xl:w-[35%] bg-white flex items-center justify-center p-8 md:p-16 relative overflow-y-auto">
        <!-- Minimalist Floating Navigation -->
        <div class="absolute top-0 left-0 right-0 p-8 flex justify-between items-center z-20 pointer-events-none">
            <a href="<?= site_url() ?>" class="pointer-events-auto group flex items-center space-x-3 text-slate-400 hover:text-blue-600 transition-all duration-300">
                <div class="w-10 h-10 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:bg-white group-hover:border-blue-400 group-hover:shadow-lg group-hover:shadow-blue-500/10 transition-all duration-500">
                    <i class="fa-solid fa-arrow-left text-[10px] group-hover:-translate-x-1 transition-transform"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] leading-none">Ke Beranda</span>
                    <span class="text-[8px] font-bold text-slate-300 uppercase tracking-widest mt-1 group-hover:text-blue-300 transition-colors">Situs Desa</span>
                </div>
            </a>
            <div class="text-[10px] font-black text-slate-200 uppercase tracking-[0.4em] hidden sm:block">Login Admin</div>
        </div>

        <div class="w-full max-w-md">
            <!-- Mobile Header -->
            <div class="lg:hidden mb-12 text-center">
                <img src="<?= gambar_desa($header['logo']) ?>" alt="Logo" class="h-16 w-auto mx-auto mb-4" />
                <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?= $header['nama_desa'] ?></h1>
                <p class="text-slate-500 text-sm font-medium">Panel Administrasi</p>
            </div>

            <div class="mb-10">
                <h2 class="font-display text-3xl font-extrabold text-slate-900 mb-2">Masuk Akun</h2>
                <p class="text-slate-500 font-medium">Silakan masukkan kredensial administrator.</p>
            </div>

            <?php if ($notif = $this->session->flashdata('notif')) : ?>
                <div class="mb-8 p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-start space-x-3 text-blue-700 text-sm font-medium">
                    <i class="fa-solid fa-circle-info text-blue-500 mt-1"></i>
                    <p><?= $notif ?></p>
                </div>
            <?php endif ?>

            <form id="validasi" action="<?= $form_action ?>" method="post" class="space-y-6">
                <!-- CSRF Token (Manual Fallback) -->
                <?php if ($this->config->config['csrf_protection']): ?>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <?php endif ?>

                <?php if ($this->session->flashdata('time_block')): ?>
                    <div class="text-center py-10 bg-red-50 rounded-[2.5rem] border border-red-100">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-full mb-4">
                            <i class="fa-solid fa-user-lock text-3xl"></i>
                        </div>
                        <h3 class="font-display font-bold text-lg text-red-800 mb-1">Akses Diblokir</h3>
                        <p id="countdown" class="text-red-500 font-bold uppercase tracking-wider text-xs"></p>
                    </div>
                <?php else: ?>
                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Username</label>
                            <div class="relative group">
                                <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input name="username" type="text" autocomplete="off" placeholder="Nama pengguna" 
                                    <?php jecho($this->session->siteman_wait, 1, 'disabled') ?> 
                                    class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required" maxlength="100">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Password</label>
                            <div class="relative group">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                                <input id="password" name="password" type="password" autocomplete="off" placeholder="Kata sandi" 
                                    <?php jecho($this->session->siteman_wait, 1, 'disabled') ?> 
                                    class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required" maxlength="100">
                            </div>
                        </div>

                        <?php if (setting('google_recaptcha')): ?>
                            <div class="pt-2"><div class="g-recaptcha" data-sitekey="<?= setting('google_recaptcha_site_key') ?>"></div></div>
                        <?php endif ?>

                        <div class="flex items-center justify-between pt-2">
                            <label class="flex items-center cursor-pointer group select-none">
                                <input type="checkbox" id="checkbox" class="sr-only">
                                <div class="w-10 h-6 bg-slate-200 rounded-full p-1 transition-colors peer-checked:bg-blue-600">
                                    <div class="w-4 h-4 bg-white rounded-full shadow-sm transition-transform" id="toggle-dot"></div>
                                </div>
                                <span class="ml-3 text-xs font-bold text-slate-600">Lihat Sandi</span>
                            </label>
                            <a href="<?= site_url('siteman/lupa_sandi') ?>" class="text-xs font-bold text-blue-600 hover:underline">Lupa Sandi?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn-modern w-full h-16 rounded-2xl text-white font-display font-extrabold tracking-wide text-sm flex items-center justify-center space-x-3 mt-8">
                        <span>MASUK KE SISTEM</span>
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>

                    <?php if ($attempts_error = $this->session->flashdata('attempts_error')): ?>
                        <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center space-x-3 text-red-700 text-xs font-bold uppercase">
                            <i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i>
                            <p><?= $attempts_error ?></p>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            </form>

            <!-- Footer Section -->
            <div class="mt-16 text-center border-t border-slate-100 pt-8">
                <p class="text-slate-400 text-[10px] tracking-widest uppercase mb-3 font-bold">Powered By</p>
                <div class="flex items-center justify-center space-x-2">
                    <span class="font-display font-black text-slate-900 text-xl tracking-tighter">OpenSID</span>
                    <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-bold"><?= AmbilVersi() ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function start_countdown() {
            var times = eval(<?= json_encode($this->session->flashdata('time_block') + config_item('lockout_time'), JSON_THROW_ON_ERROR) ?>) - eval(<?= json_encode(time(), JSON_THROW_ON_ERROR) ?>);
            var menit = Math.floor(times / 60);
            var detik = times % 60;
            timer = setInterval(function() {
                detik--;
                if (detik <= 0 && menit >= 1) { detik = 60; menit--; }
                if (menit <= 0 && detik <= 0) { clearInterval(timer); location.reload(); } 
                else { document.getElementById("countdown").innerHTML = "Coba lagi dalam " + menit + ":" + (detik < 10 ? '0' + detik : detik); }
            }, 1000);
        }

        $(document).ready(function() {
            $('#checkbox').change(function() {
                var pass = $("#password");
                var dot = $("#toggle-dot");
                if ($(this).is(':checked')) {
                    pass.attr('type', 'text');
                    dot.addClass('translate-x-4');
                } else {
                    pass.attr('type', 'password');
                    dot.removeClass('translate-x-4');
                }
            });
            if ($('#countdown').length) start_countdown();
        });
    </script>
    <script src='https://www.google.com/recaptcha/api.js?hl=id'></script>
</body>
</html>