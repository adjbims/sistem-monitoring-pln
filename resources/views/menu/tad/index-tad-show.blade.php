@extends('layouts.default')

@section('main-content')
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">
				Preview Tad
		</h1>

		<!-- Detail Section -->
		<div class="card mb-4 shadow">
				<div class="card-body">
						<!-- Tipe -->
						<div class="form-group">
								<label for="tipe">Tipe</label>
								<p>{{ $kelola_pegawai->tipe }}</p>
						</div>

						<!-- NIP -->
						{{-- <div class="form-group" @if ($kelola_pegawai->tipe == 'tad') style="display: none;" @endif>
								<label for="nip">NIP</label>
								<p>{{ $kelola_pegawai->nip }}</p>
						</div>

						<div class="form-group" @if ($kelola_pegawai->tipe == 'mitra') style="display: none;" @endif>
								<label for="nip">NIP</label>
								<p>{{ $kelola_pegawai->nip }}</p>
						</div> --}}

						<!-- Name -->
						<div class="form-group">
								<label for="name">Name</label>
								<p>{{ $kelola_pegawai->user->name }}</p>
						</div>

						<!-- Last Name -->
						<div class="form-group">
								<label for="last_name">Last Name</label>
								<p>{{ $kelola_pegawai->user->last_name }}</p>
						</div>

						<!-- Min Transaksi -->
						<div class="form-group">
								<label for="min_transaksi">Min Transaksi</label>
								<p>{{ $kelola_pegawai->min_transaksi }}</p>
						</div>

						<hr class="mt-2">
						<p>
								<strong>Login Information</strong>
						</p>

						<!-- Email -->
						<div class="form-group">
								<label for="email">Email Address</label>
								<p>{{ $kelola_pegawai->user->email }}</p>
						</div>
				</div>
		</div>
@endsection
