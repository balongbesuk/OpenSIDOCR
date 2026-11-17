@include('admin.layouts.components.asset_datatables')
@extends('admin.layouts.index')

@section('title')
<h1>
  Hari Libur Kehadiran
</h1>
@endsection

@section('breadcrumb')
<li class="active">Hari Libur Kehadiran</li>
@endsection

@push('css')
<style>
  /* Standar Kalender Bulanan & Ergonomi UI sesuai design.md */
  .table-calendar {
    table-layout: fixed;
    margin-bottom: 0;
    border: 1px solid #cbd5e1;
    background-color: #ffffff;
  }
  .table-calendar th {
    padding: 10px 4px !important;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    border-bottom: 2px solid #cbd5e1 !important;
    background-color: #f1f5f9;
    color: #1e293b;
  }
  .table-calendar td {
    height: 95px;
    vertical-align: top !important;
    padding: 6px !important;
    border-color: #e2e8f0 !important;
    transition: background-color 0.15s ease;
  }
  .table-calendar td:hover {
    background-color: #f8fafc !important;
  }
  .cal-badge-holiday {
    margin-top: 4px;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    line-height: 1.3;
    color: #ffffff !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
    word-break: break-word;
  }
  .cal-badge-holiday.libur-nasional {
    background-color: #dc2626 !important; /* WCAG AA Contrast Pass: 4.9:1 */
  }
  .cal-badge-holiday.cuti-bersama {
    background-color: #b45309 !important; /* WCAG AA Contrast Pass: 4.8:1 */
  }
  .nav-tabs#tab-hari-libur > li > a {
    font-size: 13.5px;
    font-weight: 500;
    color: #475569;
    border-radius: 4px 4px 0 0;
  }
  .nav-tabs#tab-hari-libur > li.active > a,
  .nav-tabs#tab-hari-libur > li.active > a:hover {
    font-weight: 600;
    color: #0f172a;
    border-top: 3px solid #0284c7;
  }
  #cal-month-summary,
  #cal-month-summary ul,
  #cal-month-summary li,
  #cal-month-summary li strong {
    color: #0f172a !important;
  }
  #cal-month-summary .label {
    color: #ffffff !important;
  }

  /* Responsive Mobile (< 768px) sesuai design.md */
  @media (max-width: 767px) {
    .table-calendar th {
      font-size: 11px;
      padding: 6px 1px !important;
    }
    .table-calendar td {
      height: 58px !important;
      padding: 3px 2px !important;
    }
    .table-calendar td .cal-day-num {
      font-size: 12px !important;
    }
    /* Di layar HP (viewport 360px-420px): dot indikator bulat agar ZERO HORIZONTAL SCROLL */
    .cal-badge-holiday {
      display: inline-block !important;
      width: 7px !important;
      height: 7px !important;
      min-width: 7px !important;
      padding: 0 !important;
      border-radius: 50% !important;
      font-size: 0 !important;
      line-height: 0 !important;
      margin-top: 2px !important;
      margin-right: 2px !important;
      vertical-align: middle !important;
      box-shadow: none !important;
    }
    .cal-controls-toolbar {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .cal-controls-toolbar .btn-group {
      width: 100%;
      display: flex;
    }
    .cal-controls-toolbar .btn-group .btn {
      flex: 1;
      min-height: 38px;
      line-height: 38px;
      padding: 0 8px;
      font-size: 13px;
    }
    .cal-title-wrap {
      text-align: center;
      margin: 4px 0;
    }
    .cal-legend-wrap {
      text-align: center !important;
    }
    .nav-tabs#tab-hari-libur > li {
      width: 50%;
      text-align: center;
    }
    .nav-tabs#tab-hari-libur > li > a {
      min-height: 38px;
      padding: 10px 6px;
    }
  }

  @media (min-width: 768px) {
    .cal-controls-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }
    .cal-controls-toolbar .btn-group .btn {
      min-height: 34px;
      line-height: 34px;
      padding: 0 14px;
    }
  }
</style>
@endpush

@section('content')

@include('admin.layouts.components.notifikasi')

<div class="box box-info">
  <div class="box-header with-border">
    @if (can('u'))
      <a href="{{ route('kehadiran_hari_libur.form') }}" class="btn btn-social btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-plus"></i> Tambah</a>
      <a href="{{ route('kehadiran_hari_libur.import') }}" class="btn btn-social btn-info btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-calendar"></i> Import</a>
    @endif
    @if (can('h'))
      <a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('mainform', '{{ route('kehadiran_hari_libur.delete') }}')" class="btn btn-social btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus</a>
    @endif  
    <select name="tahun" id="filter_tahun" class="form-control input-sm select2">
      <option value="semua">Semua Tahun</option>
      @foreach ($tahun as $thn)
        <option value="{{ $thn }}" {{ $thn == $tahun_ini ? 'selected' : '' }}>Tahun {{ $thn }}</option>
      @endforeach
    </select>
  </div>
  <div class="box-body">
    <ul class="nav nav-tabs" id="tab-hari-libur" style="margin-bottom: 15px;">
      <li class="active"><a href="#pane-tabel" data-toggle="tab"><i class="fa fa-list"></i> Daftar Tabel</a></li>
      <li><a href="#pane-kalender" data-toggle="tab"><i class="fa fa-calendar"></i> Kalender Bulanan</a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane active" id="pane-tabel">
        {!! form_open(null, 'id="mainform" name="mainform"') !!}
        <div class="table-responsive">
          <table class="table table-bordered table-hover" id="tabeldata">
            <thead>
              <tr>
                <th><input type="checkbox" id="checkall"/></th>
                <th class="padat">NO</th>
                <th class="aksi text-left">AKSI</th>
                <th>TANGGAL</th>
                <th>KETERANGAN</th>
              </tr>
            </thead>
          </table>
        </div>
        </form>
      </div>

      <div class="tab-pane" id="pane-kalender">
        <div class="cal-controls-toolbar" style="margin-bottom: 15px;">
          <div>
            <div class="btn-group">
              <button type="button" class="btn btn-default" id="cal-prev" title="Bulan Sebelumnya"><i class="fa fa-chevron-left"></i></button>
              <button type="button" class="btn btn-default" id="cal-today">Hari Ini</button>
              <button type="button" class="btn btn-default" id="cal-next" title="Bulan Berikutnya"><i class="fa fa-chevron-right"></i></button>
            </div>
          </div>
          <div class="cal-title-wrap">
            <span id="cal-title" style="font-size: 17px; font-weight: bold; color: #0f172a;"></span>
          </div>
          <div class="cal-legend-wrap">
            <span class="label" style="background-color: #dc2626; color: #fff; display: inline-block; padding: 5px 8px; font-size: 11px;"><i class="fa fa-circle"></i> Libur Nasional</span> &nbsp;
            <span class="label" style="background-color: #b45309; color: #fff; display: inline-block; padding: 5px 8px; font-size: 11px;"><i class="fa fa-circle"></i> Cuti Bersama</span> &nbsp;
            <span class="label label-info" style="display: inline-block; padding: 5px 8px; font-size: 11px;"><i class="fa fa-circle"></i> Hari Ini</span>
          </div>
        </div>

        <div class="table-responsive" style="border: none;">
          <table class="table table-bordered table-calendar" id="calendar-grid">
            <thead>
              <tr>
                <th class="text-center" style="color: #dc2626; width: 14.28%;">Minggu</th>
                <th class="text-center" style="width: 14.28%;">Senin</th>
                <th class="text-center" style="width: 14.28%;">Selasa</th>
                <th class="text-center" style="width: 14.28%;">Rabu</th>
                <th class="text-center" style="width: 14.28%;">Kamis</th>
                <th class="text-center" style="width: 14.28%;">Jumat</th>
                <th class="text-center" style="width: 14.28%;">Sabtu</th>
              </tr>
            </thead>
            <tbody id="cal-body">
            </tbody>
          </table>
        </div>

        <div id="cal-month-summary" style="margin-top: 15px;"></div>
      </div>
    </div>
  </div>
</div>

@include('admin.layouts.components.konfirmasi_hapus')

@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    $('#filter_tahun').select2();

    var TableData = $('#tabeldata').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('kehadiran_hari_libur.datatables') }}",
        data: function (d) {
          d.tahun = $('#filter_tahun').val();
        }
      },
      columns: [
        { data: 'ceklist', class: 'padat', searchable: false, orderable: false },
        { data: 'DT_RowIndex', class: 'padat', searchable: false, orderable: false },
        { data: 'aksi', class: 'aksi text-left', searchable: false, orderable: false },
        { data: 'tanggal', name: 'tanggal', searchable: true, orderable: true },
        { data: 'keterangan', name: 'keterangan', searchable: true, orderable: true },
      ],
      order: [[ 3, 'asc' ]]
    });

    // Calendar logic
    var listHariLibur = @json($semua_libur ?? []);
    var currentCalYear = parseInt($('#filter_tahun').val()) || new Date().getFullYear();
    if (isNaN(currentCalYear) || currentCalYear < 2000) {
      currentCalYear = new Date().getFullYear();
    }
    var currentCalMonth = new Date().getMonth();

    var monthNames = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    var holidayMap = {};
    if (Array.isArray(listHariLibur)) {
      listHariLibur.forEach(function (item) {
        if (!holidayMap[item.tanggal]) {
          holidayMap[item.tanggal] = [];
        }
        var isCuti = (item.keterangan || '').toLowerCase().indexOf('cuti bersama') !== -1;
        holidayMap[item.tanggal].push({
          id: item.id,
          keterangan: item.keterangan,
          isCuti: isCuti
        });
      });
    }

    function renderCalendar(year, month) {
      $('#cal-title').text(monthNames[month] + ' ' + year);

      var firstDay = new Date(year, month, 1).getDay();
      var daysInMonth = new Date(year, month + 1, 0).getDate();
      var daysInPrevMonth = new Date(year, month, 0).getDate();

      var today = new Date();
      var todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

      var html = '';
      var dayCount = 1;
      var nextMonthDay = 1;
      var monthHolidays = [];

      for (var week = 0; week < 6; week++) {
        html += '<tr>';
        for (var col = 0; col < 7; col++) {
          var cellIndex = week * 7 + col;

          if (cellIndex < firstDay) {
            var prevDay = daysInPrevMonth - (firstDay - 1 - cellIndex);
            html += '<td style="background-color: #f8fafc; color: #94a3b8;">' +
                    '<span class="cal-day-num" style="font-weight: 500; font-size: 12px;">' + prevDay + '</span></td>';
          } else if (dayCount <= daysInMonth) {
            var dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(dayCount).padStart(2, '0');
            var isToday = (dateStr === todayStr);
            var isSunday = (col === 0);
            var holidays = holidayMap[dateStr] || [];

            var cellBg = '#ffffff';
            if (holidays.length > 0) {
              cellBg = holidays[0].isCuti ? '#fffdf0' : '#fff5f5';
              holidays.forEach(function (h) {
                monthHolidays.push({ tanggal: dateStr, day: dayCount, keterangan: h.keterangan, isCuti: h.isCuti });
              });
            } else if (isSunday) {
              cellBg = '#fef2f2';
            }

            if (isToday) {
              cellBg = '#eff6ff';
            }

            var borderStyle = isToday ? 'border: 2px solid #0284c7 !important;' : '';

            html += '<td style="background-color: ' + cellBg + '; ' + borderStyle + '">';

            var dayColor = (isSunday || holidays.length > 0) ? '#dc2626' : '#1e293b';
            if (holidays.length > 0 && holidays[0].isCuti) {
              dayColor = '#b45309';
            }

            var todayBadge = isToday ? ' <span class="badge bg-blue hidden-xs" style="font-size: 9px; padding: 2px 4px; vertical-align: text-top;">Hari ini</span>' : '';
            html += '<div class="cal-day-num" style="font-weight: bold; font-size: 13px; color: ' + dayColor + ';">' + dayCount + todayBadge + '</div>';

            if (holidays.length > 0) {
              holidays.forEach(function (h) {
                var badgeClass = h.isCuti ? 'cuti-bersama' : 'libur-nasional';
                html += '<div class="cal-badge-holiday ' + badgeClass + '" title="' + h.keterangan + '">' +
                        h.keterangan + '</div>';
              });
            }

            html += '</td>';
            dayCount++;
          } else {
            html += '<td style="background-color: #f8fafc; color: #94a3b8;">' +
                    '<span class="cal-day-num" style="font-weight: 500; font-size: 12px;">' + nextMonthDay + '</span></td>';
            nextMonthDay++;
          }
        }
        html += '</tr>';
        if (dayCount > daysInMonth) {
          break;
        }
      }

      $('#cal-body').html(html);

      // Render Month Summary
      var summaryHtml = '';
      if (monthHolidays.length > 0) {
        summaryHtml += '<div style="margin-bottom: 0; background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #0284c7; border-radius: 4px; padding: 12px 15px; color: #0f172a;">' +
                       '<h5 style="margin-top: 0; font-weight: bold; color: #0f172a;"><i class="fa fa-info-circle text-blue"></i> Hari Libur & Cuti Bersama di Bulan ' + monthNames[month] + ' ' + year + ':</h5>' +
                       '<ul style="margin-bottom: 0; padding-left: 20px; color: #0f172a;">';
        monthHolidays.forEach(function (mh) {
          var badge = mh.isCuti ? '<span class="label" style="background-color: #b45309; color: #ffffff !important;">Cuti Bersama</span>' : '<span class="label" style="background-color: #dc2626; color: #ffffff !important;">Libur Nasional</span>';
          summaryHtml += '<li style="margin-bottom: 6px; font-size: 13px; color: #0f172a;"><strong style="color: #0f172a;">' + mh.day + ' ' + monthNames[month] + ' ' + year + '</strong> : ' + mh.keterangan + ' ' + badge + '</li>';
        });
        summaryHtml += '</ul></div>';
      } else {
        summaryHtml += '<div style="margin-bottom: 0; background-color: #f8fafc; border: 1px solid #e2e8f0; color: #475569; font-size: 13px; border-radius: 4px; padding: 12px 15px;">' +
                       '<i class="fa fa-calendar-check-o text-muted"></i> Tidak ada hari libur nasional atau cuti bersama di bulan ' + monthNames[month] + ' ' + year + '.</div>';
      }
      $('#cal-month-summary').html(summaryHtml);
    }

    $('#cal-prev').on('click', function () {
      currentCalMonth--;
      if (currentCalMonth < 0) {
        currentCalMonth = 11;
        currentCalYear--;
      }
      renderCalendar(currentCalYear, currentCalMonth);
    });

    $('#cal-next').on('click', function () {
      currentCalMonth++;
      if (currentCalMonth > 11) {
        currentCalMonth = 0;
        currentCalYear++;
      }
      renderCalendar(currentCalYear, currentCalMonth);
    });

    $('#cal-today').on('click', function () {
      var t = new Date();
      currentCalYear = t.getFullYear();
      currentCalMonth = t.getMonth();
      renderCalendar(currentCalYear, currentCalMonth);
    });

    $('#filter_tahun').on('select2:select change', function () {
      TableData.ajax.reload();
      var val = $(this).val();
      if (val !== 'semua') {
        currentCalYear = parseInt(val);
        renderCalendar(currentCalYear, currentCalMonth);
      }
    });

    $('a[href="#pane-kalender"]').on('shown.bs.tab', function () {
      renderCalendar(currentCalYear, currentCalMonth);
    });

    $('a[href="#pane-tabel"]').on('shown.bs.tab', function () {
      TableData.columns.adjust().responsive.recalc();
    });
  });
</script>
@endpush
