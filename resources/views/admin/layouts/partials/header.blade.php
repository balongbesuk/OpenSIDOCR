<header class="main-header">
    <style>
        @media (max-width: 767px) {
            /* Navbar 1 Bar di Mobile */
            .main-header {
                position: relative;
                height: 50px !important;
                max-height: 50px !important;
            }

            .main-header .navbar {
                width: 100% !important;
                float: none !important;
                margin: 0 !important;
                min-height: 50px !important;
                height: 50px !important;
                position: relative;
            }

            .main-header .sidebar-toggle {
                float: left !important;
                position: relative;
                z-index: 1002;
                height: 50px;
                line-height: 20px;
                padding: 15px !important;
            }

            /* Judul / Logo OpenSID tepat di tengah navbar mobile */
            .mobile-navbar-title {
                position: absolute !important;
                left: 50% !important;
                top: 0 !important;
                transform: translateX(-50%) !important;
                height: 50px !important;
                line-height: 50px !important;
                color: #ffffff !important;
                font-size: 18px !important;
                font-weight: bold !important;
                text-align: center !important;
                white-space: nowrap !important;
                text-decoration: none !important;
                z-index: 1000 !important;
                max-width: calc(100% - 130px);
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .mobile-navbar-title:hover,
            .mobile-navbar-title:focus {
                color: #ffffff !important;
                text-decoration: none !important;
            }

            /* Menu kanan (profil) */
            .main-header .navbar-custom-menu {
                float: right !important;
                position: relative;
                z-index: 1002;
            }

            .main-header .navbar-custom-menu .navbar-nav > li > a {
                padding: 7px 12px !important;
                height: 50px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            /* Foto Profil lebih besar dan jelas di mobile */
            .main-header .navbar-custom-menu .user-image {
                width: 36px !important;
                height: 36px !important;
                border-radius: 50% !important;
                border: 2px solid rgba(255, 255, 255, 0.85) !important;
                object-fit: cover !important;
                margin: 0 !important;
                float: none !important;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
            }

            /* Badge notifikasi di foto profil */
            .main-header .navbar-custom-menu .avatar-badge {
                position: absolute !important;
                top: 5px !important;
                right: 5px !important;
                margin: 0 !important;
                padding: 2px 5px !important;
                font-size: 10px !important;
                line-height: 1 !important;
                border-radius: 10px !important;
                background-color: #dd4b39 !important;
                color: #ffffff !important;
                border: 1.5px solid #ffffff !important;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3) !important;
            }

            /* Sesuaikan jarak konten & sidebar agar pas di bawah 50px */
            .main-sidebar,
            .control-sidebar,
            .fixed .content-wrapper,
            .fixed .right-side {
                padding-top: 50px !important;
            }
        }
    </style>

    {{-- Logo OpenSID untuk tampilan desktop --}}
    <a href="{{ route('/') }}" target="_blank" class="logo hidden-xs">
        <span class="logo-mini"><b>SID</b></span>
        <span class="logo-lg"><b>OpenSID</b></span>
    </a>

    <nav class="navbar navbar-static-top">
        {{-- Tombol Hamburger di sebelah kiri --}}
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        {{-- Judul OpenSID di tengah khusus tampilan mobile --}}
        <a href="{{ route('/') }}" target="_blank" class="mobile-navbar-title visible-xs-block">
            <b>OpenSID</b>
        </a>

        <div class="navbar-custom-menu">
            @php
                $is_mobile = $ci->agent->is_mobile();
                $rilis_info = $rilis ?? cek_pembaruan_aplikasi();
                $total_notif = 0;
                if (can('b', 'permohonan_surat_admin') && !empty($notif['surat'])) {
                    $total_notif += (int)$notif['surat'];
                }
                if (can('b', 'komentar') && !empty($notif['komentar'])) {
                    $total_notif += (int)$notif['komentar'];
                }
                if (can('b', 'mailbox') && !empty($notif['inbox'])) {
                    $total_notif += (int)$notif['inbox'];
                }
                if (can('b', 'keluar') && (setting('verifikasi_kades') || setting('verifikasi_sekdes')) && !empty($notif['permohonansurat'])) {
                    $total_notif += (int)$notif['permohonansurat'];
                }
                if (in_array('343', array_column($modul, 'id')) && can('b', 'opendk_pesan') && !empty($notif['opendkpesan'])) {
                    $total_notif += (int)$notif['opendkpesan'];
                }
                if (!empty($notif['langganan']) && can('b', 'layanan-pelanggan') && ($notif['langganan']['status'] ?? 0) > 2) {
                    $total_notif += 1;
                }
            @endphp

            <ul class="nav navbar-nav">
                {{-- Menu navigasi ikon notifikasi untuk tampilan desktop --}}
                @if (!$is_mobile)
                    @if ($notif['langganan'] && can('b', 'layanan-pelanggan'))
                        <li class="hidden-xs">
                            <a href="{{ route('pelanggan') }}">
                                <i class="fa {{ $notif['langganan']['ikon'] }} fa-lg"
                                    title="Status Langganan {{ $notif['langganan']['masa'] }} hari"
                                    style="color: {{ $notif['langganan']['warna'] }}"></i>&nbsp;
                                @if ($notif['langganan']['status'] > 2)
                                    <span class="badge" id="b_langganan"></span>
                                @endif
                            </a>
                        </li>
                    @endif

                    @if (in_array('343', array_column($modul, 'id')) && can('b', 'opendk_pesan'))
                        <li class="komunikasi-opendk hidden-xs">
                            <a href="{{ route('opendk_pesan.clear') }}">
                                <i class="fa fa-university fa-lg" title="Komunikasi OpenDK"></i>&nbsp;
                                @if ($notif['opendkpesan'])
                                    <span class="badge" id="b_opendkpesan">{{ $notif['opendkpesan'] }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    @if (can('b', 'permohonan_surat_admin'))
                        <li class="hidden-xs">
                            <a href="{{ route('permohonan_surat_admin') }}">
                                <i class="fa fa-print fa-lg" title="Cetak Surat"></i>&nbsp;
                                @if ($notif['surat'])
                                    <span class="badge" id="b_permohonan_surat">{{ $notif['surat'] }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    @if (can('b', 'komentar'))
                        <li class="hidden-xs">
                            <a href="{{ route('komentar') }}">
                                <i class="fa fa-commenting-o fa-lg" title="Komentar"></i>&nbsp;
                                @if ($notif['komentar'])
                                    <span class="badge" id="b_komentar">{{ $notif['komentar'] }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    @if (can('b', 'mailbox'))
                        <li class="hidden-xs">
                            <a href="{{ route('mailbox') }}">
                                <i class="fa fa-envelope-o fa-lg" title="Pesan Masuk"></i>&nbsp;
                                @if ($notif['inbox'])
                                    <span class="badge" id="b_inbox">{{ $notif['inbox'] }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    @if (can('b', 'keluar') && (setting('verifikasi_kades') || setting('verifikasi_sekdes')))
                        <li class="hidden-xs">
                            <a href="{{ route('keluar.clear.masuk') }}">
                                <span><i class="fa fa-bell-o fa-lg" title="Permohonan Surat"></i>&nbsp;</span>
                                @if ($notif['permohonansurat'])
                                    <span class="badge" id="permohonan">{{ $notif['permohonansurat'] }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endif

                {{-- Dropdown Profil Pengguna --}}
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="position: relative;">
                        <img src="{{ AmbilFoto($auth->foto) }}" class="user-image" alt="User Image" />
                        <span class="hidden-xs">{{ $auth->nama }}</span>
                        @if ($total_notif > 0)
                            <span class="badge avatar-badge {{ $is_mobile ? '' : 'visible-xs-inline-block' }}">
                                {{ $total_notif }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ AmbilFoto($auth->foto) }}" class="img-circle" alt="User Image" />
                            <p>
                                <small>Anda Masuk Sebagai</small>
                                {{ $auth->nama }}
                            </p>
                        </li>

                        {{-- Menu item notifikasi & informasi yang disatukan ke dropdown profil untuk mobile --}}
                        <li class="user-body {{ $is_mobile ? '' : 'visible-xs-block' }}" style="padding: 0; background-color: #fff; max-height: 260px; overflow-y: auto;">
                            <ul class="menu" style="list-style: none; padding: 0; margin: 0;">
                                @if ($notif['langganan'] && can('b', 'layanan-pelanggan'))
                                    <li style="border-bottom: 1px solid #f4f4f4;">
                                        <a href="{{ route('pelanggan') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                            <span>
                                                <i class="fa {{ $notif['langganan']['ikon'] }} fa-lg" style="width: 25px; color: {{ $notif['langganan']['warna'] }}"></i>
                                                Status Langganan
                                            </span>
                                            @if ($notif['langganan']['status'] > 2)
                                                <span class="label label-warning pull-right">Penting</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if (in_array('343', array_column($modul, 'id')) && can('b', 'opendk_pesan'))
                                    <li class="komunikasi-opendk" style="border-bottom: 1px solid #f4f4f4;">
                                        <a href="{{ route('opendk_pesan.clear') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                            <span>
                                                <i class="fa fa-university fa-lg text-green" style="width: 25px;"></i>
                                                Komunikasi OpenDK
                                            </span>
                                            @if ($notif['opendkpesan'])
                                                <span class="label label-danger pull-right">{{ $notif['opendkpesan'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if (can('b', 'permohonan_surat_admin'))
                                    <li style="border-bottom: 1px solid #f4f4f4;">
                                        <a href="{{ route('permohonan_surat_admin') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                            <span>
                                                <i class="fa fa-print fa-lg text-aqua" style="width: 25px;"></i>
                                                Cetak Surat
                                            </span>
                                            @if ($notif['surat'])
                                                <span class="label label-danger pull-right">{{ $notif['surat'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if (can('b', 'komentar'))
                                    <li style="border-bottom: 1px solid #f4f4f4;">
                                        <a href="{{ route('komentar') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                            <span>
                                                <i class="fa fa-commenting-o fa-lg text-yellow" style="width: 25px;"></i>
                                                Komentar
                                            </span>
                                            @if ($notif['komentar'])
                                                <span class="label label-danger pull-right">{{ $notif['komentar'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if (can('b', 'mailbox'))
                                    <li style="border-bottom: 1px solid #f4f4f4;">
                                        <a href="{{ route('mailbox') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                            <span>
                                                <i class="fa fa-envelope-o fa-lg text-primary" style="width: 25px;"></i>
                                                Pesan Masuk
                                            </span>
                                            @if ($notif['inbox'])
                                                <span class="label label-danger pull-right">{{ $notif['inbox'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                @if (can('b', 'keluar') && (setting('verifikasi_kades') || setting('verifikasi_sekdes')))
                                    <li style="border-bottom: 1px solid #f4f4f4;">
                                        <a href="{{ route('keluar.clear.masuk') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                            <span>
                                                <i class="fa fa-bell-o fa-lg text-red" style="width: 25px;"></i>
                                                Permohonan Surat
                                            </span>
                                            @if ($notif['permohonansurat'])
                                                <span class="label label-danger pull-right">{{ $notif['permohonansurat'] }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- Menu Informasi / Bantuan (hanya untuk admin) --}}
                                @if (is_admin())
                                    <li style="border-bottom: 1px solid #f4f4f4;">
                                        <a href="#" data-toggle="modal" data-target="#modal-informasi" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                            <span>
                                                <i class="fa fa-question-circle fa-lg text-aqua" style="width: 25px;"></i>
                                                Informasi
                                            </span>
                                            @if (!empty($rilis_info['update_available']))
                                                <span class="label label-success pull-right" style="font-size: 10px;">Update</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif

                                {{-- Menu Pengaturan jika tersedia --}}
                                @if ($kategori && can('u', $controller))
                                    <li style="border-bottom: 1px solid #f4f4f4;">
                                        @if ($controller === 'pelanggan')
                                            <a href="#" class="atur-token" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                                <span>
                                                    <i class="fa fa-gear fa-lg text-muted" style="width: 25px;"></i>
                                                    Pengaturan
                                                </span>
                                            </a>
                                        @else
                                            <a href="#" data-remote="false" data-toggle="modal"
                                                data-title="Pengaturan {{ ucwords($controller) }}" data-target="#pengaturan" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; color: #444; text-decoration: none;">
                                                <span>
                                                    <i class="fa fa-gear fa-lg text-muted" style="width: 25px;"></i>
                                                    Pengaturan {{ ucwords($controller) }}
                                                </span>
                                            </a>
                                        @endif
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= site_url('pengguna') ?>" class="btn bg-maroon btn-sm">Profil</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('siteman.logout') }}" class="btn bg-maroon btn-sm">Keluar</a>
                            </div>
                        </li>
                    </ul>
                </li>

                {{-- Ikon Informasi untuk tampilan desktop (hanya untuk admin) --}}
                @if (is_admin())
                    <li class="hidden-xs">
                        <a href="#" data-toggle="modal" data-target="#modal-informasi" title="Informasi" style="position: relative;">
                            <i class="fa fa-question-circle fa-lg"></i>
                            @if (!empty($rilis_info['update_available']))
                                <span class="badge" style="position: absolute; top: 7px; right: 2px; margin: 0; padding: 2px 4px; font-size: 8px; line-height: 1; border-radius: 50%; background-color: #00a65a; color: #fff;" title="Pembaruan Tersedia">!</span>
                            @endif
                        </a>
                    </li>
                @endif
                {{-- Ikon Pengaturan untuk tampilan desktop --}}
                @if ($kategori && can('u', $controller))
                    <li class="hidden-xs">
                        @if ($controller === 'pelanggan')
                            <a href="#" class="atur-token">
                        @else
                            <a href="#" data-remote="false" data-toggle="modal"
                                data-title="Pengaturan {{ ucwords($controller) }}" data-target="#pengaturan">
                        @endif
                        <span><i class="fa fa-gear"></i>&nbsp;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
