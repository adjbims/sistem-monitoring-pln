$(document).ready(function () {
  var table = $('#dataTable').DataTable();

  $('input[name="tahun"], input[name="bulan"]').change(function () {
    var tahun = $('input[name="tahun"]:checked').val();
    var bulan = $('input[name="bulan"]:checked').val();
    var regexPattern = tahun + '-' + (bulan < 10 ? '0' + bulan : bulan) + '-\\d\\d';
    table.column(4).search(regexPattern, true, false).draw();
  });
});
