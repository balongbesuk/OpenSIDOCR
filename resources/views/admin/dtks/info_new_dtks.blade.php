Versi Formulir DTKS saat ini : <b id="versi">
    {{ \App\Enums\Dtks\DtksEnum::VERSION_LIST[\App\Enums\Dtks\DtksEnum::VERSION_CODE] }}
</b>
<br>
<div id="info_versi_dtks">

</div>
@if (modul_aktif('dtks'))
<script>
    $(document).on('shown.bs.modal', '#show_confirm_modal, #modal-tambah-dtks', function () {
        if ($('#info_versi_dtks').is(':empty')) {
            $('#info_versi_dtks').load("<?=route('dtks/loadRecentInfo')?>");
        }
    });
</script>
@endif