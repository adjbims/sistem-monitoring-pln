$(document).ready(function () {
  var table = $('#dataTable').DataTable();

  $('input[name="tahun"], input[name="bulan"]').change(function () {
    var tahun = $('input[name="tahun"]:checked').val();
    var bulan = $('input[name="bulan"]:checked').val();
    var regexPattern = tahun + '-' + (bulan < 10 ? '0' + bulan : bulan) + '-\\d\\d';
    table.column(4).search(regexPattern, true, false).draw();
  });

  $('#resetFilter').click(function () {
    $('input[name="tahun"][value="' + new Date().getFullYear() + '"]').prop('checked', true);
    $('input[name="bulan"][value="' + (new Date().getMonth() + 1) + '"]').prop('checked', true);
    table.column(4).search('').draw();
  });

  $('#exportExcelBtn').click(function () {
    var tahun = $('input[name="tahun"]:checked').val() || '';
    var bulan = $('input[name="bulan"]:checked').val() || '';
    // var exportUrl = "{{ route('data-transaksi.export.excel') }}/" + tahun + "/" + bulan;
    var exportUrl = `data-transaksi/export/excel/${tahun}/${bulan}`;
    $(this).attr('href', exportUrl);
  });
});
