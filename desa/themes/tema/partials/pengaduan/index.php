<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="pengaduan-container pb-20">
    <!-- Header Section -->
    <div class="mb-12">
        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">
            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
            <span class="text-slate-600 dark:text-slate-300">Layanan Pengaduan</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-10">
            <div>
                <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                    <span class="w-8 h-px bg-brand-600"></span>
                    Community Feedback
                </div>
                <h1 class="font-display font-[900] text-4xl md:text-6xl text-slate-900 dark:text-white leading-none tracking-tight">
                    Layanan <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Pengaduan</span>.
                </h1>
                <p class="mt-4 text-slate-500 dark:text-slate-400 font-medium max-w-2xl leading-relaxed">
                    Sampaikan aspirasi, aduan, atau laporan Anda secara transparan untuk pembangunan desa yang lebih baik.
                </p>
            </div>

            <div class="shrink-0">
                <button type="button" onclick="openCreateModal()" class="group px-8 py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-[2rem] font-black text-xs uppercase tracking-widest shadow-2xl transition-all hover:bg-brand-600 hover:text-white hover:scale-105 active:scale-95 flex items-center gap-3">
                    <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i>
                    Buat Pengaduan Baru
                </button>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl p-6 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl mb-12 flex flex-col md:flex-row gap-4">
        <form action="<?= site_url('pengaduan') ?>" method="GET" class="flex flex-col md:flex-row gap-4 w-full">
            <div class="relative group flex-1 md:max-w-[200px]">
                <select name="caristatus" onchange="this.form.submit()" class="w-full h-14 pl-6 pr-12 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all appearance-none font-bold text-[10px] uppercase tracking-widest text-slate-400 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="1" <?= $caristatus == 1 ? 'selected' : '' ?>>Menunggu</option>
                    <option value="2" <?= $caristatus == 2 ? 'selected' : '' ?>>Proses</option>
                    <option value="3" <?= $caristatus == 3 ? 'selected' : '' ?>>Selesai</option>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
            </div>

            <div class="relative group flex-1">
                <input type="text" name="cari" value="<?= $cari ?>" placeholder="Cari berdasarkan judul atau isi aduan..." class="w-full h-14 pl-12 pr-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all font-medium text-sm text-slate-900 dark:text-white placeholder:text-slate-400">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-brand-500 transition-colors"></i>
            </div>

            <button type="submit" class="h-14 px-8 bg-brand-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-brand-900 transition-all shadow-xl shadow-brand-600/20">
                Filter Data
            </button>
        </form>
    </div>

    <!-- Notifications -->
    <?php if ($notif = session('notif')): ?>
        <div class="mb-10 animate-slide-up">
            <div class="<?= $notif['status'] == 'error' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-green-50 text-green-600 border-green-100' ?> p-6 rounded-[2rem] border flex items-center gap-4 shadow-lg shadow-brand-900/5">
                <i class="fa-solid <?= $notif['status'] == 'error' ? 'fa-circle-exclamation' : 'fa-circle-check' ?> text-2xl"></i>
                <p class="font-bold text-sm uppercase tracking-wide"><?= $notif['pesan'] ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Pengaduan List Grid -->
    <?php if ($pengaduan): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php foreach ($pengaduan as $item): ?>
                <div class="group relative bg-white dark:bg-slate-900 rounded-[3rem] p-10 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5 transition-all duration-500 hover:-translate-y-2 hover:shadow-brand-900/10 flex flex-col cursor-pointer" onclick='showDetail(<?= json_encode($item) ?>)'>
                    
                    <!-- Top Info row -->
                    <div class="flex items-start justify-between mb-8">
                        <div class="flex flex-col gap-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Aduan Masuk</span>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-calendar-day text-brand-600 text-xs"></i>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest"><?= tgl_indo($item['created_at']) ?></span>
                            </div>
                        </div>

                        <?php 
                            $status_class = "bg-red-600";
                            $status_text = "Menunggu";
                            switch($item['status']) {
                                case 2: $status_class = "bg-cyan-600"; $status_text = "Proses"; break;
                                case 3: $status_class = "bg-emerald-600"; $status_text = "Selesai"; break;
                            }
                        ?>
                        <span class="px-4 py-1.5 rounded-xl <?= $status_class ?> text-white font-black text-[9px] uppercase tracking-[0.2em] shadow-lg shadow-brand-900/20">
                            <?= $status_text ?>
                        </span>
                    </div>

                    <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white leading-tight mb-6 group-hover:text-brand-600 transition-colors line-clamp-2">
                        <?= $item['judul'] ?>
                    </h3>

                    <div class="relative mb-8">
                        <p class="text-slate-500 dark:text-slate-400 font-medium leading-relaxed italic line-clamp-3">
                            "<?= $item['isi'] ?>"
                        </p>
                    </div>

                    <!-- Bottom row: User & Comments -->
                    <div class="mt-auto pt-8 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-brand-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-user-shield text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Pengadu</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white"><?= $item['nama'] ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800">
                            <i class="fa-solid fa-comments text-brand-600 text-xs"></i>
                            <span class="text-[10px] font-black text-slate-600 dark:text-slate-300"><?= count(array_filter($pengaduan_balas, fn($b) => $b['id_pengaduan'] == $item['id'])) ?> Tanggapan</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paging -->
        <div class="mt-20">
            <?php $this->load->view("{$folder_themes}/commons/paging.php", ['paging' => $paging, 'paging_page' => 'pengaduan']) ?>
        </div>

    <?php else: ?>
        <div class="py-32 text-center bg-white dark:bg-slate-900 rounded-[4rem] border border-slate-100 dark:border-slate-800 shadow-2xl mt-10">
            <div class="w-32 h-32 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center mx-auto mb-8 text-slate-200 dark:text-slate-700">
                <i class="fa-solid fa-inbox text-6xl"></i>
            </div>
            <h3 class="font-display font-[800] text-2xl text-slate-900 dark:text-white mb-2 tracking-tight">Belum ada pengaduan.</h3>
            <p class="text-slate-500 font-medium">Ayo sampaikan aspirasi Anda untuk memajukan desa kita.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal: Buat Pengaduan -->
<div class="premium-modal" id="newpengaduan">
    <div class="premium-modal-backdrop"></div>
    <div class="premium-modal-content">
        <div class="p-10 md:p-14">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="font-display font-black text-3xl text-slate-900 dark:text-white leading-tight">Buat Pengaduan Baru</h2>
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mt-2">Identify and Report Identity Securely</p>
                </div>
                <button type="button" class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all" data-premium-dismiss>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

                <form action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <?php $old = session('data') ?? []; ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">NIK (KTP)</label>
                            <input name="nik" type="text" maxlength="16" class="w-full h-16 px-8 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-bold text-sm text-slate-900 dark:text-white placeholder:text-slate-300" placeholder="Masukkan 16 digit NIK" value="<?= $old['nik'] ?? '' ?>" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Nama Lengkap</label>
                            <input name="nama" type="text" class="w-full h-16 px-8 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-bold text-sm text-slate-900 dark:text-white placeholder:text-slate-300" placeholder="Nama sesuai KTP" value="<?= $old['nama'] ?? '' ?>" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Email Aktif</label>
                            <input name="email" type="email" class="w-full h-16 px-8 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-bold text-sm text-slate-900 dark:text-white placeholder:text-slate-300" placeholder="contoh@gmail.com" value="<?= $old['email'] ?? '' ?>">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Telepon / WA</label>
                            <input name="telepon" type="text" class="w-full h-16 px-8 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-bold text-sm text-slate-900 dark:text-white placeholder:text-slate-300" placeholder="08xxxxxxxxxxx" value="<?= $old['telepon'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Judul Aduan</label>
                        <input name="judul" type="text" class="w-full h-16 px-8 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-bold text-sm text-slate-900 dark:text-white placeholder:text-slate-300" placeholder="Contoh: Infrastruktur Jalan Rusak" value="<?= $old['judul'] ?? '' ?>" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Isi Pengaduan</label>
                        <textarea name="isi" class="w-full p-8 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-medium text-sm text-slate-600 dark:text-slate-300 leading-relaxed min-h-[150px]" placeholder="Jelaskan detail pengaduan Anda..." required><?= $old['isi'] ?? '' ?></textarea>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Lampiran Foto (Opsional)</label>
                        <div class="relative group">
                            <input type="file" name="foto" id="file_pengaduan" accept="image/*" class="hidden" onchange="previewImg(this)">
                            <div onclick="$('#file_pengaduan').click()" class="w-full h-32 rounded-[2rem] border-4 border-dashed border-slate-100 dark:border-slate-800 flex flex-col items-center justify-center gap-2 cursor-pointer group-hover:bg-slate-50 dark:group-hover:bg-slate-800/40 transition-all">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-200"></i>
                                <span id="file_name" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Klik Untuk Pilih Foto</span>
                            </div>
                        </div>
                        <img id="preview_aduan" class="w-32 h-32 object-cover rounded-3xl hidden shadow-xl border-4 border-white">
                    </div>

                    <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div class="bg-slate-100 dark:bg-slate-800 p-2 rounded-2xl overflow-hidden shrink-0">
                                <img src="<?= site_url('captcha') ?>" id="captcha_img" class="h-10 w-auto rounded-xl">
                            </div>
                            <button type="button" onclick="document.getElementById('captcha_img').src = '<?= site_url('captcha') ?>?' + Math.random();" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-brand-600 hover:bg-brand-600 hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-rotate"></i>
                            </button>
                            <input type="text" name="captcha_code" class="w-32 h-14 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border-none focus:ring-2 focus:ring-brand-500/20 font-black text-center text-sm" placeholder="KODE" required>
                        </div>

                        <button type="submit" class="w-full md:w-auto h-16 px-12 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-[2rem] font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-brand-600 hover:text-white hover:scale-105 active:scale-95 transition-all">
                            Kirim Pengaduan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Detail Pengaduan -->
<div class="premium-modal" id="pengaduan-detail">
    <div class="premium-modal-backdrop"></div>
    <div class="premium-modal-content">
        <div class="p-10 md:p-14">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span id="detail-status" class="px-4 py-1.5 rounded-xl text-white font-black text-[9px] uppercase tracking-[0.2em] mb-4 inline-block">STATUS</span>
                    <h2 id="detail-judul" class="font-display font-black text-3xl text-slate-900 dark:text-white leading-tight">Judul Aduan</h2>
                </div>
                <button type="button" class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all" data-premium-dismiss>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

                <div class="space-y-8">
                    <div class="p-10 bg-slate-50 dark:bg-slate-800/40 rounded-[3rem] border border-slate-100 dark:border-slate-800 italic text-slate-600 dark:text-slate-300 leading-relaxed">
                        <p id="detail-isi">Isi pengaduan...</p>
                    </div>

                    <div id="detail-foto-box" class="hidden">
                        <img id="detail-foto" class="w-full rounded-[2.5rem] shadow-xl">
                    </div>

                    <div class="flex items-center justify-between py-6 border-y border-slate-100 dark:border-slate-800">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brand-600/10 text-brand-600 flex items-center justify-center">
                                <i class="fa-solid fa-user-tag"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Oleh Masyarakat</p>
                                <p id="detail-nama" class="font-bold text-slate-900 dark:text-white">Nama Pengadu</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Diterima Pada</p>
                            <p id="detail-tgl" class="font-bold text-slate-900 dark:text-white">Tanggal</p>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    <div id="detail-replies" class="space-y-6">
                        <h4 class="font-display font-black text-xl text-slate-900 dark:text-white flex items-center gap-4">
                            <span class="w-1.5 h-6 bg-accent rounded-full"></span>
                            Tanggapan Resmi
                        </h4>
                        <!-- Mockup reply -->
                        <div class="p-8 bg-emerald-50 dark:bg-emerald-900/10 rounded-[2.5rem] border border-emerald-100 dark:border-emerald-800/50">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white text-[10px]">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Admin Desa</span>
                            </div>
                            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-300 italic">"Terima kasih atas laporannya. Tim kami akan segera meninjau lokasi tersebut besok pagi."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let createModal, detailModal;

function openCreateModal() {
    if (!createModal) createModal = new PremiumModal('newpengaduan');
    createModal.show();
}

function showDetail(item) {
    if (!detailModal) detailModal = new PremiumModal('pengaduan-detail');
    
    $('#detail-judul').text(item.judul);
    $('#detail-isi').text(item.isi);
    $('#detail-nama').text(item.nama);
    $('#detail-tgl').text(item.created_at);
    
    let statusClass = "bg-red-600";
    let statusText = "Menunggu";
    if(item.status == 2) { statusClass = "bg-cyan-600"; statusText = "Proses"; }
    else if(item.status == 3) { statusClass = "bg-emerald-600"; statusText = "Selesai"; }
    
    $('#detail-status').removeClass().addClass('px-4 py-1.5 rounded-xl text-white font-black text-[9px] uppercase tracking-[0.2em] mb-4 inline-block ' + statusClass).text(statusText);

    if(item.foto) {
        $('#detail-foto').attr('src', '<?= base_url(LOKASI_GALERI) ?>' + item.foto);
        $('#detail-foto-box').removeClass('hidden');
    } else {
        $('#detail-foto-box').addClass('hidden');
    }

    const allReplies = <?= json_encode($pengaduan_balas) ?>;
    const itemReplies = allReplies.filter(r => r.id_pengaduan == item.id);
    const replyContainer = $('#detail-replies');
    
    replyContainer.find('.reply-item').remove();
    if(itemReplies.length > 0) {
        itemReplies.forEach(reply => {
            replyContainer.append(`
                <div class="reply-item p-8 bg-brand-50 dark:bg-brand-900/10 rounded-[2.5rem] border border-brand-100 dark:border-brand-800/50 animate-fade-in">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white text-[10px]">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <span class="text-xs font-black text-brand-600 uppercase tracking-widest">${reply.nama}</span>
                        <span class="text-[9px] text-slate-400 ml-auto">${reply.created_at}</span>
                    </div>
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 italic">"${reply.isi}"</p>
                </div>
            `);
        });
    } else {
        replyContainer.append('<p class="reply-item text-slate-400 font-bold text-xs italic ml-6 select-none opacity-50">Belum ada tanggapan resmi.</p>');
    }

    detailModal.show();
}

function previewImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview_aduan').attr('src', e.target.result).removeClass('hidden');
            $('#file_name').text(input.files[0].name);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    <?php if (session('data')): ?>
        openCreateModal();
    <?php endif; ?>
});
</script>

<style>
@keyframes slide-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slide-up { animation: slide-up 0.5s ease forwards; }

.modal.fade .modal-dialog { transform: scale(0.95); transition: transform 0.3s ease-out; }
.modal.show .modal-dialog { transform: scale(1); }

/* CRITICAL FIX: Ensure modal is ALWAYS on top regardless of parent stacking context */
.modal { z-index: 100000 !important; }
.modal-backdrop { z-index: 99999 !important; }

/* Dark mode fixes for modal */
.dark .modal-content { background-color: #0f172a; border: 1px solid #1e293b; }
</style>
