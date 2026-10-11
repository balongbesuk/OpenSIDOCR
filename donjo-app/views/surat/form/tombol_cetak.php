<div class="box-footer">
    <?php if ($mandiri): ?>
        <button type="reset" onclick="window.history.back();" class="btn btn-social btn-flat btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
    <?php elseif ($periksa): ?>
        <a href="<?= site_url("permohonan_surat_admin/konfirmasi/{$periksa['id']}"); ?>" class="btn btn-social btn-flat btn-danger btn-sm" data-remote="false" data-toggle="modal" data-target="#modalBox" data-title="Konfirmasi Belum Lengkap"><i class="fa fa-times"></i> Belum Lengkap</a>
    <?php else: ?>
        <button type="reset" onclick="$('#validasi').trigger('reset');" class="btn btn-social btn-flat btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
    <?php endif; ?>
    <?php if ($mandiri): ?>
        <button type="button" id="btn_kirim_mandiri" onclick="kirim_permohonan_mandiri(this);" class="btn btn-social btn-flat btn-success btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-file-text"></i> Kirim</button>
    <?php else: ?>
        <?php if (SuratExport($url) && function_exists('exec') && $this->setting->libreoffice_path) : ?>
            <button type="button" onclick="tambah_elemen_cetak('cetak_pdf');" class="btn btn-social btn-flat bg-fuchsia btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"></i> Cetak PDF</button>
        <?php endif; ?>
        <?php if (SuratExport($url)): ?>
            <button type="button" onclick="tambah_elemen_cetak('cetak_rtf');" id="btn_cetak_rtf" class="btn btn-social btn-flat bg-purple btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-file-word-o"></i> Unduh RTF</button>
        <?php endif; ?>
        <?php if (in_array($surat['jenis'], [3, 4])): ?>
            <button type="button" onclick="tambah_elemen_cetak('cetak_pdf');" class="btn btn-social btn-flat bg-fuchsia btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-file-word-o"></i> Cetak PDF</button>
        <?php endif; ?>
    <?php endif; ?>
    <a href="<?= site_url('keluar/clear/masuk') ?>" id="next" class="btn btn-social btn-info btn-sm btn-sm pull-right visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" style="display: none !important;">
            ke Permohonan Surat<i class="fa fa-arrow-circle-right"></i></a>
</div>
<script type="text/javascript">
    function kirim_permohonan_mandiri(btn) {
        var form = document.getElementById('validasi');
        if (!form) return;

        // Pastikan token CSRF selalu terisi terbaru
        if (typeof addCsrfField === 'function') {
            addCsrfField(form);
        } else if (typeof getCsrfToken === 'function' && typeof csrfParam !== 'undefined') {
            var csrfInput = form.querySelector('input[name="' + csrfParam + '"]');
            if (!csrfInput) {
                csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = csrfParam;
                form.appendChild(csrfInput);
            }
            csrfInput.value = getCsrfToken();
        }

        $(btn).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengirim...');
        form.action = '<?= site_url(MANDIRI . '/surat/kirim/' . ($permohonan['id'] ?? '')) ?>';
        form.submit();
    }

    function tambah_elemen_cetak($nilai) {
        $('<input>').attr({
                type: 'hidden',
                name: 'submit_cetak',
                value: $nilai
        }).appendTo($('#validasi'));

        if ($nilai == 'cetak_rtf' || $nilai == 'cetak_pdf') {
            $('#validasi').submit();

            if ($('.box-body').find('.has-error').length < 1) {
                $('#btn_cetak_rtf').hide();
                $('#next').show();
            }

        }

    }
</script>
