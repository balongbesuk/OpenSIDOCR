@extends('admin.layouts.index')
@include('admin.layouts.components.asset_validasi')

@push('css')
    <style>
        .pengguna-page .box-profile {
            text-align: center;
            padding: 20px 15px;
        }
        .pengguna-page .box-profile .penduduk {
            display: block;
            margin: 0 auto;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .pengguna-page .pengguna-verif-actions {
            margin-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .pengguna-page .pengguna-verif-actions form {
            margin: 0;
        }
        .pengguna-page .input-group-addon[class*="reveal-"] {
            cursor: pointer;
        }
        .pengguna-page .box-footer {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            padding: 10px 15px;
        }
        .pengguna-page .box-footer::before,
        .pengguna-page .box-footer::after {
            display: none;
            content: none;
        }
        .pengguna-page .box-footer .btn[type="submit"] {
            margin-left: auto;
        }
        @media (min-width: 768px) {
            .pengguna-page .form-control.input-sm,
            .pengguna-page .input-group-sm > .form-control {
                height: 34px;
                font-size: 13px;
                border-radius: 4px;
            }
            .pengguna-page .input-group .form-control {
                height: 34px;
                border-radius: 4px 0 0 4px;
            }
            .pengguna-page .input-group-btn .btn,
            .pengguna-page .input-group-addon {
                height: 34px;
                min-height: 34px;
                border-radius: 0 4px 4px 0;
                font-size: 13px;
            }
            .pengguna-page .btn-group .btn {
                height: 34px;
                line-height: 22px;
                font-size: 13px;
            }
            .pengguna-page .box-footer .btn,
            .pengguna-page .pengguna-verif-actions .btn {
                min-height: 34px;
                height: 34px;
                line-height: 34px;
                padding: 0 12px 0 36px;
                border-radius: 4px;
                font-size: 13px;
                font-weight: 500;
            }
            .pengguna-page .pengguna-verif-actions .btn {
                padding: 0 12px;
            }
        }
        @media (max-width: 767px) {
            .pengguna-page .input-group .form-control,
            .pengguna-page .input-group-btn .btn,
            .pengguna-page .input-group-addon {
                height: 38px;
                min-height: 38px;
            }
            .pengguna-page .box-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            .pengguna-page .box-footer .btn {
                width: 100%;
                min-height: 38px;
                height: 38px;
                line-height: 38px;
                margin-left: 0 !important;
                border-radius: 4px;
            }
        }
    </style>
@endpush

@section('title')
    <h1>
        Pengguna <small>Ubah Data</small>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('pengguna') }}">Pengguna</a></li>
    <li class="active">Profil</li>
@endsection

@section('content')
    @include('admin.layouts.components.notifikasi')
    <div class="row pengguna-page">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="penduduk" id="foto" src="{{ AmbilFoto(auth()->foto) }}" alt="Foto Penduduk">
                    @php
                        $showVerifEmail    = $userData->email_verified_at === null && !empty($userData->email);
                        $showVerifTelegram = $userData->telegram_verified_at === null && setting('telegram_token') != null && !empty($userData->id_telegram);
                    @endphp
                    @if ($showVerifEmail || $showVerifTelegram)
                        <div class="pengguna-verif-actions">
                            @if ($showVerifEmail)
                                {!! form_open(route('pengguna.kirim_verifikasi')) !!}
                                <button type="submit" class="btn btn-sm btn-warning btn-block"><i
                                        class="fa fa-share-square"></i>
                                    Verifikasi Email</button>
                                </form>
                            @endif
                            @if ($showVerifTelegram)
                                <button type="button" id="verif_telegram"
                                    class="btn btn-sm btn-warning btn-block"><i class="fa fa-share-square"></i>
                                    Verifikasi Telegram</button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#profil" data-toggle="tab">Profil</a></li>
                    <li><a href="#sandi" data-toggle="tab">Sandi</a></li>
                </ul>
                <div class="tab-content">
                    @include('admin.pengguna.tab-profil')
                    @include('admin.pengguna.tab-sandi')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let _hash = window.location.hash.substring(1)
            if (_hash) {
                $('ul.nav.nav-tabs a[href="#' + _hash + '"]').click()
            }

            $('#verif_telegram').click(function() {
                Swal.fire({
                    title: 'Mengirim OTP',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                $.ajax({
                        url: '{{ route('pengguna.kirim_otp_telegram') }}',
                        type: 'Post',
                        data: {
                            'sidcsrf': getCsrfToken(),
                            'id_telegram': $('#id_telegram').val()
                        },
                    })
                    .done(function(response) {
                        if (response.status == true) {
                            Swal.fire({
                                title: 'Masukan Kode OTP',
                                input: 'text',
                                inputPlaceholder: 'Masukan Kode OTP',
                                inputValidator: (value) => {
                                    if (isNaN(value)) {
                                        return 'Kode OTP harus berupa angka'
                                    }
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Kirim',
                                cancelButtonText: 'Tutup',
                                showLoaderOnConfirm: true,
                                preConfirm: (otp) => {
                                    const formData = new FormData();
                                    formData.append('sidcsrf', getCsrfToken());
                                    formData.append('id_telegram', response.data);
                                    formData.append('otp', otp);

                                    return fetch(
                                            `{{ route('pengguna.verifikasi_telegram') }}`, {
                                                method: 'POST',
                                                body: formData,
                                            }).then(response => {
                                            if (!response.ok) {
                                                throw new Error(response.statusText)
                                            }
                                            return response.json()
                                        })
                                        .catch(error => {
                                            Swal.showValidationMessage(
                                                `Request failed: ${error}`
                                            )
                                        })
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if (result.value.status == true) {
                                        $('.close').trigger("click"); //close modal
                                        Swal.fire({
                                            icon: 'success',
                                            title: result.value.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: result.value.message
                                        })
                                    }
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: response.messages,
                            })
                        }
                    })
                    .fail(function(e) {
                        Swal.fire({
                            icon: 'error',
                            text: e.statusText,
                        })
                    });
            });

            $('input[name=notif_telegram]').change(function() {
                let _val = parseInt($('input[name=notif_telegram]:checked').val())
                if (_val) {
                    $('#id_telegram').closest('.form-group').removeClass('hide')
                } else {
                    $('#id_telegram').closest('.form-group').addClass('hide')
                }
            })
        });
    </script>
@endpush
