@extends('layouts.default')

@push('styles')
		<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">
				History Bukti Pembayaran
		</h1>
		<p class="mb-4">
				History bukti pembayaran yang telah diupload oleh user.
		</p>

		@if (session('success'))
				<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
						{{ session('success') }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
				</div>
		@endif

		@if ($errors->any())
				<div class="alert alert-danger border-left-danger" role="alert">
						<ul class="my-2 pl-4">
								@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
								@endforeach
						</ul>
				</div>
		@endif

		<!-- DataTales Example -->
		<div class="card mb-4 shadow">
				<div class="card-header py-3">
						<h6 class="font-weight-bold text-primary m-0">DataTables Example</h6>
				</div>
				<div class="card-body">
						<div class="filter-container mb-3">
								<div class="row">
										<div class="col-12">
												<div class="form-group">
														<label for="tahun">Tahun:</label>
														<div class="btn-group btn-group-toggle" data-toggle="buttons">
																@foreach (range(2023, date('Y')) as $year)
																		<label class="btn btn-outline-primary {{ $year == date('Y') ? 'active' : '' }}">
																				<input type="radio" name="tahun" value="{{ $year }}" autocomplete="off"
																						{{ $year == date('Y') ? 'checked' : '' }}> {{ $year }}
																		</label>
																@endforeach
														</div>
												</div>
										</div>
										<div class="col-12">
												<div class="form-group">
														<label for="bulan">Bulan:</label>
														<div class="btn-group btn-group-toggle" data-toggle="buttons">
																@foreach (range(1, 12) as $month)
																		<label class="btn btn-outline-primary {{ $month == date('n') ? 'active' : '' }}">
																				<input type="radio" name="bulan" value="{{ $month }}" autocomplete="off"
																						{{ $month == date('n') ? 'checked' : '' }}> {{ date('F', mktime(0, 0, 0, $month, 1)) }}
																		</label>
																@endforeach
														</div>
												</div>
										</div>
								</div>
						</div>

						<div class="table-responsive">
								<table class="table-bordered table" id="dataTable" width="100%" cellspacing="0">
										<thead>
												<tr>
														<th>No</th>
														<th>Nama Lengkap</th>
														<th>Email</th>
														<th>Tipe</th>
														<th>Total Tansaksi</th>
														<th>Minimal Transaksi</th>
														<th>Status</th>
														<th>created_at</th>
												</tr>
										</thead>
										<tfoot>
												<tr>
														<th>No</th>
														<th>Nama Lengkap</th>
														<th>Email</th>
														<th>Tipe</th>
														<th>Total Tansaksi</th>
														<th>Minimal Transaksi</th>
														<th>Status</th>
														<th>created_at</th>

												</tr>
										</tfoot>
										<tbody>
												@foreach ($data as $row)
														<tr>
																<td>{{ $loop->iteration }}</td>
																<td>{{ $row->user->name }} {{ $row->user->last_name }}</td>
																<td>{{ $row->user->email }}</td>
																<td>{{ $row->user->pegawai->tipe }}</td>
																<td>{{ $row->total_transaksi }}</td>
																<td>{{ $row->min_transaksi }}</td>
																<td>
																		@if ($row->total_transaksi >= $row->min_transaksi)
																				<span class="badge rounded-pill bg-success p-1 text-white">Targset Terpenuhi</span>
																		@else
																				<span class="badge rounded-pill bg-danger p-1 text-white">Tidak memenuhi target</span>
																		@endif
																</td>
																<td>{{ $row->created_at }}</td>

														</tr>
												@endforeach
										</tbody>
								</table>
						</div>
				</div>
		</div>
@endsection

@push('scripts')
		<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
