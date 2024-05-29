@extends('layouts.default')

@push('styles')
		<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">Kelola Data Mitra</h1>
		<p class="mb-2">
				Kelola data mitra yang terdaftar di sistem.
		</p>
		<a href="{{ route('kelola-mitra.create') }}" class="btn btn-success btn-icon-split mb-4">
				<span class="icon text-white-50">
						<i class="fas fa-arrow-right"></i>
				</span>
				<span class="text">Daftar Mitra Baru</span>
		</a>

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
						<h6 class="font-weight-bold text-primary m-0">
								Data Mitra
						</h6>
				</div>
				<div class="card-body">
						<div class="table-responsive">
								<table class="table-bordered table" id="dataTable" width="100%" cellspacing="0">
										<thead>
												<tr>
														<th>No</th>
														<th>Nama Lengkap</th>
														<th>Email</th>
														<th>Tipe</th>
														<th>Total Transaksi</th>
														<th>Min Transaksi</th>
														<th>Action</th>
												</tr>
										</thead>
										<tfoot>
												<th>No</th>
												<th>Nama Lengkap</th>
												<th>Email</th>
												<th>Tipe</th>
												<th>Total Transaksi</th>
												<th>Min Transaksi</th>
												<th>Action</th>
										</tfoot>
										<tbody>
												@foreach ($data as $row)
														<tr>
																<td>{{ $loop->iteration }}</td>
																<td>{{ $row->user->name }} {{ $row->user->last_name }}</td>
																<td>{{ $row->user->email }}</td>
																<td>{{ $row->tipe }}</td>
																<td>{{ $row->total_transaksi }}</td>
																<td>{{ $row->min_transaksi }}</td>
																<td>
																		<a href="{{ route('kelola-mitra.show', $row->id) }}" class="btn btn-info btn-sm">Detail</a>
																		<a href="{{ route('kelola-mitra.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
																		<form action="{{ route('kelola-mitra.destroy', $row->id) }}" method="POST" class="d-inline">
																				@csrf
																				@method('DELETE')
																				<button type="submit" class="btn btn-danger btn-sm"
																						onclick="return confirm('Are you sure to delete this data?')">Delete</button>
																		</form>
																</td>
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
