@extends('layouts.default')

@section('main-content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">
    Detail Transaksi
  </h1>

  <!-- Detail Section -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <!-- Nama Lengkap -->
      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <p>{{ $data_transaksi->user->name }} {{ $data_transaksi->user->last_name }}</p>
      </div>

      <!-- Tipe -->
      <div class="form-group">
        <label for="tipe">Tipe</label>
        <p>{{ $data_transaksi->user->pegawai->tipe }}</p>
      </div>

      <!-- NIP -->
      <div class="form-group" @if ($data_transaksi->user->pegawai->tipe == 'tad') style="display: none;" @endif>
        <label for="nip">NIP</label>
        <p>{{ $data_transaksi->user->pegawai->nip }}</p>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="email">Email Address</label>
        <p>{{ $data_transaksi->user->email }}</p>
      </div>

      <!-- File -->
      <div class="form-group">
        <label for="email">Bukti Transfer</label>
        <p>
          <a href="{{ asset('storage/bukti_transfer/' . $data_transaksi->bukti_transfer) }}"
            target="_blank">{{ $data_transaksi->bukti_transfer }}</a>
        </p>
      </div>

      <!-- Created At -->
      <div class="form-group">
        <label for="created_at">Created At</label>
        <p>{{ $data_transaksi->created_at }}</p>
      </div>
    </div>
  </div>
@endsection
