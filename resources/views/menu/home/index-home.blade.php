@extends('layouts.default')

@section('main-content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    <!-- Success Alert -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Status Alert -->
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="container-fluid">
        <div class="row mb-4">
            <!-- Total Transaksi Widget -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow h-100 py-2 border-left-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['transaksi_total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Users Widget or Progress Task Widget -->
            @if (Auth::user()->role == 'admin')
            <div class="col-lg-3 mb-4">
                <div class="card shadow h-100 py-2 border-left-warning">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Users') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['users'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-lg-3 mb-4">
                <div class="card shadow h-100 py-2 border-left-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Progress Task</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $widget['pegawai_task_percentage'] }}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $widget['pegawai_task_percentage'] }}%" aria-valuenow="{{ $widget['pegawai_task_percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    
            <!-- Average Weekly Transactions Widget -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow h-100 py-2 border-left-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Average Weekly Transactions</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($widget['transaksi_perweek_avg']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Monthly Transactions Widget -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow h-100 py-2 border-left-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Monthly Transactions') }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($widget['transaksi_total_month']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
<!-- Transaksi Perbulan -->
<div class="row mb-4">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Transaksi Perbulan') }}</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="monthlyTransaksiChart"></canvas>
                </div>
                <div class="mt-4 text-right">
                    <a href="#" id="downloadChart" class="btn btn-primary">{{ __('Download Chart') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

    
        <!-- Last 10 Users Transacted -->
        <div class="row mb-4">
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Last 10 Users Transacted') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($widget['transaksi'] as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->user->name }} {{ $row->user->last_name }}</td>
                                        <td>{{ $row->user->email }}</td>
                                        <td>{{ $row->tanggal }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="/data-transaksi" class="btn btn-primary">Data lebih lengkap&rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
    
        <!-- Top 5 Users by Transactions (Admin only) -->
        @if (Auth::user()->role == 'admin')
            <div class="row mb-4">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('Top 5 Users by Transactions') }}</h6>
                        </div>
                        <div class="card-body">                            <ul class="list-group list-group-flush">
                            @foreach ($widget['top_users'] as $user)
                                <li class="list-group-item">{{ $user->name }} ({{ $user->transaksi_count }} transactions)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk mengunduh grafik sebagai gambar
        function downloadChart() {
            var canvas = document.getElementById('monthlyTransaksiChart');
            var dataURL = canvas.toDataURL("image/png");
            var link = document.createElement("a");
            link.href = dataURL;
            link.download = "transaksi_perbulan.png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    
        // Fungsi untuk memformat angka dengan ribuan
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    
        // Inisialisasi chart
        var ctx = document.getElementById("monthlyTransaksiChart").getContext('2d');
        var monthlyTransaksiChart;
        var labels = {!! isset($widget['transaksi_perbulan']) ? json_encode($widget['transaksi_perbulan']->pluck('month_year')) : '[]' !!};
        var data = {!! isset($widget['transaksi_perbulan']) ? json_encode($widget['transaksi_perbulan']->pluck('count')) : '[]' !!};
    
        monthlyTransaksiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Transaksi",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: data
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 12
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    
        // Menghubungkan fungsi downloadChart dengan tombol unduh
        document.getElementById('downloadChart').addEventListener('click', downloadChart);
    });
    </script>    
@endpush