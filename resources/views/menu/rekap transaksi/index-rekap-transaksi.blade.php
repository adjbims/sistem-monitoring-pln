@extends('layouts.default')

@push('styles')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">
    History Bukti Pembayarann
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
      <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>Tipe</th>
              <th>Tanggal</th>
              <th>File</th>
              <th>created_at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>Tipe</th>
              <th>Tanggal</th>
              <th>File</th>
              <th>created_at</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach ($data as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->user->name }} {{ $row->user->last_name }}</td>
                <td>{{ $row->user->email }}</td>
                <td>{{ $row->user->pegawai->tipe}}</td>
                <td>{{ $row->tanggal }}</td>
                <td><a href="{{ asset('storage/bukti_transfer/' . $row->bukti_transfer) }}"
                    target="_blank">{{ $row->bukti_transfer }}</a></td>
                <td>{{ $row->created_at }}</td>
                <td>
                  <a href="{{ route('data-transaksi.show', $row->id) }}" class="btn btn-info btn-sm">Detail</a>
                  <a href="{{ route('data-transaksi.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                  <form action="{{ route('data-transaksi.destroy', $row->id) }}" method="POST" class="d-inline">
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
