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
    
    <style type="text/css">
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
        }
        .login-gradient {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(37, 99, 235, 0.8) 100%);
        }
        .input-premium {
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-premium:focus {
            background: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .btn-modern {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.4);
            filter: brightness(1.1);
        }
        .panel-left-bg {
            background: url('<?= $latar_login ?>') no-repeat center center;
            background-size: cover;
        }
    </style>

    <script src="<?= asset('bootstrap/js/jquery.min.js') ?>"></script>
    <script src="<?= asset('js/jquery.validate.min.js') ?>"></script>
    <script src="<?= asset('js/validasi.js') ?>"></script>
    <script src="<?= asset('js/localization/messages_id.js') ?>"></script>
</head>

<body class="min-h-screen flex overflow-hidden">
    <!-- PANEL KIRI: Visual & Branding (Shared) -->
    <div class="hidden lg:flex lg:w-3/5 xl:w-[65%] relative overflow-hidden panel-left-bg">
        <div class="absolute inset-0 login-gradient"></div>
        
        <div class="relative z-10 flex flex-col justify-between p-16 w-full text-white">
            <div class="flex items-center space-x-4">
                <img src="<?= gambar_desa($header['logo']) ?>" alt="Logo" class="h-16 w-auto drop-shadow-xl" />
                <div>
                    <h2 class="font-display font-bold text-xl tracking-tight leading-none uppercase">
                        Portal Resmi <?= ucwords($this->setting->sebutan_desa) ?>
                    </h2>
                    <p class="text-white/70 text-sm font-medium">Layanan Atur Ulang Sandi</p>
                </div>
            </div>

            <div>
                <h1 class="font-display text-6xl xl:text-7xl font-extrabold leading-[1.1] mb-6">
                    Akses Kembali <span class="text-blue-200">Akun Anda.</span>
                </h1>
                <p class="text-blue-100/80 text-lg xl:text-xl font-medium leading-relaxed max-w-xl">
                    Silakan buat kata sandi baru yang kuat untuk melindungi akun Anda. Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.
                </p>
            </div>

            <div class="flex items-center space-x-8">
                <div class="flex flex-col">
                    <span class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-bold mb-2">Didukung Oleh</span>
                    <div class="flex items-center space-x-2 text-white/90">
                        <span class="font-display font-black text-2xl tracking-tighter">OpenSID</span>
                        <span class="bg-white/10 px-2 py-0.5 rounded text-[10px] font-bold"><?= AmbilVersi() ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL KANAN: Form Reset Sandi -->
    <div class="w-full lg:w-2/5 xl:w-[35%] bg-white flex items-center justify-center p-8 md:p-16 xl:p-24 relative overflow-y-auto">
        <div class="w-full max-w-md">
            <div class="mb-10 lg:mb-12">
                <h2 class="font-display text-3xl font-extrabold text-slate-900 mb-2">Buat Sandi Baru</h2>
                <p class="text-slate-500 font-medium">Pastikan kata sandi baru Anda mudah diingat namun sulit ditebak.</p>
            </div>

            <?php if ($notif = $this->session->flashdata('notif')) : ?>
                <div class="mb-8 p-4 bg-yellow-50 border border-yellow-100 rounded-2xl flex items-start space-x-3">
                    <i class="fa-solid fa-circle-exclamation text-yellow-600 mt-0.5"></i>
                    <p class="text-yellow-800 text-sm font-medium leading-relaxed"><?= $notif ?></p>
                </div>
            <?php endif ?>

            <form id="validasi" action="<?= site_url('siteman/verifikasi_sandi') ?>" method="post" class="space-y-6">
                <!-- CSRF Token -->
                <?php if ($this->config->config['csrf_protection']): ?>
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <?php endif ?>

                <div class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Email Pengguna</label>
                        <div class="relative group">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input name="email" type="text" placeholder="Email Pengguna" value="<?= $email ?>" 
                                class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 opacity-60 cursor-not-allowed" readonly>
                            <input type="hidden" name="email" value="<?= $email ?>">
                            <input type="hidden" name="token" value="<?= $token ?>">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Kata Sandi Baru</label>
                        <div class="relative group">
                            <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input name="password" type="password" placeholder="Minimal 8 karakter" autocomplete="off" 
                                class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required pwdLengthNist">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Konfirmasi Kata Sandi</label>
                        <div class="relative group">
                            <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input name="konfirmasi_password" type="password" placeholder="Ulangi kata sandi" autocomplete="off" 
                                class="input-premium w-full h-14 rounded-2xl pl-12 pr-4 text-sm font-semibold text-slate-900 required pwdLengthNist">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-modern w-full h-16 rounded-2xl text-white font-display font-extrabold tracking-wide text-sm flex items-center justify-center space-x-3">
                    <span>SIMPAN KATA SANDI</span>
                    <i class="fa-solid fa-check"></i>
                </button>
            </form>

            <div class="mt-16 text-center border-t border-slate-100 pt-8">
                <p class="text-slate-400 text-[10px] tracking-widest uppercase mb-3 font-bold">Powered By</p>
                <div class="flex items-center justify-center space-x-2">
                    <span class="font-display font-black text-slate-900 text-xl tracking-tighter">OpenSID</span>
                    <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-[10px] font-bold"><?= AmbilVersi() ?></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>