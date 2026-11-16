<div class="form-group tdk-permohonan">
  <label class="col-sm-3 control-label" for="tampil_foto">Tampilkan Foto Penduduk di Surat</label>
  <div class="col-xs-12 col-sm-6 col-lg-4">
    <div class="btn-group btn-group-justified" data-toggle="buttons">
      <label id="m1" class="btn btn-info btn-flat btn-sm form-check-label <?= jecho($tampil_foto, 1, 'active'); ?>">
        <input id="foto1" type="radio" name="tampil_foto" class="form-check-input" value="1" <?= jecho($tampil_foto, 1, 'checked'); ?> autocomplete="off"> Ya
      </label>
      <label id="m2" class="btn btn-info btn-flat btn-sm form-check-label <?= jecho($tampil_foto != 1, true, 'active'); ?>">
        <input id="foto2" type="radio" name="tampil_foto" class="form-check-input" value="0" <?= jecho($tampil_foto != 1, true, 'checked'); ?> autocomplete="off"> Tidak
      </label>
    </div>
  </div>
</div>

