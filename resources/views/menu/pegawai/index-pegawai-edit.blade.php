@extends('layouts.default')

@section('main-content')
		<!-- Page Heading -->
		<h1 class="h3 mb-2 text-gray-800">Edit Pegawai</h1>

		@if ($errors->any())
				<div class="alert alert-danger border-left-danger" role="alert">
						<ul class="my-2 pl-4">
								@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
								@endforeach
						</ul>
				</div>
		@endif

		<!-- Form Start -->
		<div class="card mb-4 shadow">
				<div class="card-body">
						<form method="POST" action="{{ route('kelola-pegawai.update', $kelola_pegawai->id) }}">
								@csrf
								@method('PUT')


								<input type="hidden" name="tipe" value="{{ $kelola_pegawai->tipe }}">

								<!-- Tipe -->
								{{-- <div class="form-group">
										<label for="tipe">Tipe</label>
										<select class="form-control" id="tipe" name="tipe">
												<option value="pegawai" @if ($kelola_pegawai->tipe == 'pegawai') selected @endif>Pegawai</option>
												<option value="tad" @if ($kelola_pegawai->tipe == 'tad') selected @endif>TAD</option>
										</select>
								</div> --}}

								<!-- NIP -->
								<div class="form-group" id="nipField" @if ($kelola_pegawai->tipe == 'tad') style="display: none;" @endif>
										<label for="nip">NIP</label>
										<input type="text" class="form-control" id="nip" name="nip"
												value="{{ old('nip', $kelola_pegawai->nip) }}">
								</div>

								<!-- Name -->
								<div class="form-group">
										<label for="name">Name</label>
										<input type="text" class="form-control" id="name" name="name"
												value="{{ old('name', $kelola_pegawai->user->name) }}" required>
								</div>

								<!-- Last Name -->
								<div class="form-group">
										<label for="last_name">Last Name</label>
										<input type="text" class="form-control" id="last_name" name="last_name"
												value="{{ old('last_name', $kelola_pegawai->user->last_name) }}" required>
								</div>

								<!-- Min Transaksi -->
								<div class="form-group">
										<label for="min_transaksi">Min Transaksi</label>
										<input type="number" class="form-control" id="min_transaksi" name="min_transaksi"
												value="{{ old('min_transaksi', $kelola_pegawai->min_transaksi) }}">
								</div>

								<hr class="mt-2">
								<p>
										<strong>Login Information</strong>
								</p>

								<!-- Email -->
								<div class="form-group">
										<label for="email">Email Address</label>
										<input type="email" class="form-control" id="email" name="email"
												value="{{ old('email', $kelola_pegawai->user->email) }}" required>
								</div>

								<!-- Password -->
								<div class="form-group">
										<label for="password">New Password</label>
										<input type="password" class="form-control" id="password" name="password">
								</div>

								<!-- Confirm Password -->
								<div class="form-group">
										<label for="password_confirmation">Confirm New Password</label>
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
								</div>

								<!-- Submit Button -->
								<button type="submit" class="btn btn-primary">Submit</button>
						</form>
				</div>
		</div>
@endsection

@push('scripts')
		<script>
				// Function to handle the change event of the Tipe field
				document.getElementById('tipe').addEventListener('change', function() {
						// If the selected value is 'tad', hide the NIP field
						if (this.value === 'tad') {
								document.getElementById('nipField').style.display = 'none';
						} else {
								// Otherwise, show the NIP field
								document.getElementById('nipField').style.display = 'block';
						}
				});
		</script>
@endpush
