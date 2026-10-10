<div class="list-frame artikel animate-premium">
    <div class="mb-10">
        <h1 class="premium-h1 text-3xl md:text-5xl uppercase tracking-tighter leading-none mb-4"><?= $detail['nama']; ?></h1>
        <div class="w-16 h-1 bg-brand-600 rounded-full"></div>
    </div>

    <div class="space-y-12">
        <!-- PENGURUS -->
        <div>
            <h3 class="font-display font-black text-xs uppercase tracking-[0.3em] text-slate-400 mb-6 flex items-center gap-3">
                <i class="fa-solid fa-user-tie text-brand-600"></i>
                Daftar Pengurus
            </h3>
            <div class="overflow-x-auto rounded-[2rem] border border-slate-100 dark:border-slate-800 overflow-hidden shadow-xl shadow-slate-200/40 dark:shadow-none">
                <?php if(count($pengurus) > 0): ?>
                    <table class="premium-table mb-0">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Jabatan</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th width="100">L/P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($pengurus as $data): ?>
                                <tr>
                                    <td class="text-center font-bold text-slate-400"><?= $no++ ?></td>
                                    <td class="font-bold text-slate-900 dark:text-white uppercase text-[10px] tracking-wider"><?= $data['jabatan'] ?></td>
                                    <td class="font-bold uppercase text-[11px]"><?= $data['nama'] ?></td>
                                    <td class="text-xs italic opacity-70"><?= $data['alamat'] ?></td>
                                    <td class="text-center font-bold text-slate-500 uppercase"><?= $data['sex'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="p-10 text-center font-bold text-slate-400 italic">Belum ada data pengurus.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ANGGOTA -->
        <div>
            <h3 class="font-display font-black text-xs uppercase tracking-[0.3em] text-slate-400 mb-6 flex items-center gap-3">
                <i class="fa-solid fa-users text-brand-600"></i>
                Daftar Anggota Kelompok
            </h3>
            <div class="overflow-x-auto rounded-[2rem] border border-slate-100 dark:border-slate-800 overflow-hidden shadow-xl shadow-slate-200/40 dark:shadow-none">
                <?php if(count($anggota) > 0): ?>
                    <table class="premium-table mb-0" id="tabel-data">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Jabatan</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th width="100">L/P</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($anggota as $data): ?>
                                <tr>
                                    <td class="text-center font-bold text-slate-400"><?= $no++ ?></td>
                                    <td class="font-bold text-slate-900 dark:text-white uppercase text-[10px] tracking-wider"><?= $data['jabatan'] ?></td>
                                    <td class="font-bold uppercase text-[11px]"><?= $data['nama'] ?></td>
                                    <td class="text-xs italic opacity-70"><?= $data['alamat'] ?></td>
                                    <td class="text-center font-bold text-slate-500 uppercase"><?= $data['sex'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="p-10 text-center font-bold text-slate-400 italic">Belum ada data anggota.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- SHARE -->
        <div class="pt-10 border-t border-slate-50 dark:border-slate-800">
            <span class="block text-[8px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-[0.5em] mb-6 text-center">Sebarkan Informasi Melalui</span>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="https://www.facebook.com/sharer.php?u=<?= site_url('data-lembaga/'.$detail['kode']) ?>" class="h-14 rounded-2xl bg-[#1877F2] text-white flex items-center justify-center gap-3 text-[10px] font-black uppercase tracking-widest hover:brightness-110 transition-all active:scale-95 shadow-lg shadow-blue-600/20">
                    <i class="fa-brands fa-facebook text-lg"></i> Facebook
                </a>
                <a href="https://x.com/share?url=<?= site_url('data-lembaga/'.$detail['kode']) ?>" class="h-14 rounded-2xl bg-black text-white flex items-center justify-center gap-3 text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all active:scale-95 shadow-lg shadow-slate-900/20">
                    <i class="fa-brands fa-x-twitter text-lg"></i> Twitter
                </a>
                <a href="https://web.whatsapp.com/send?text=<?= site_url('data-lembaga/'.$detail['kode']) ?>" class="h-14 rounded-2xl bg-[#25D366] text-white flex items-center justify-center gap-3 text-[10px] font-black uppercase tracking-widest hover:brightness-110 transition-all active:scale-95 shadow-lg shadow-emerald-600/20">
                    <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp
                </a>
                <button onclick="navigator.clipboard.writeText('<?= site_url('data-lembaga/'.$detail['kode']) ?>')" class="h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center gap-3 text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all active:scale-95">
                    <i class="fa-solid fa-link text-lg"></i> Copy Link
                </button>
            </div>
        </div>
    </div>
</div>

<div class="list-frame mt-8 bg-white dark:bg-slate-950/40 p-10 rounded-[4rem] border border-slate-100 dark:border-slate-800">
    <div id="disqus_thread"></div>
    <script>
    <?php
        $disqus_shortname = 'balongbesuk';
        $disqus_config_file = FCPATH . $folder_themes . '/commons/disqus.php';
        if (is_file($disqus_config_file)) {
            include $disqus_config_file;
        }
        $disqus_shortname = trim((string) $disqus_shortname);
    ?>
    (function() {
        var d = document, s = d.createElement('script');
        var shortname = '<?= $disqus_shortname ?>';
        if (!shortname) return;
        s.src = 'https://' + shortname + '.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
    </script>
</div>
