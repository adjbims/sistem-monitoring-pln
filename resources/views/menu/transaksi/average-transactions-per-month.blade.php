<!-- resources/views/menu/transaksi/average-transactions-per-month.blade.php -->
@extends('layouts.default')

@section('main-content')
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Average Total Transactions Per Month</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Average Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->year }}</td>
                                <td>{{ \Carbon\Carbon::create()->month($item->month)->format('F') }}</td>
                                <td>{{ number_format($item->average_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection