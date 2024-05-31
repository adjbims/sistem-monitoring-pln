@extends('layouts.default')

@push('styles')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">History Bukti Pembayaran</h1>
  <p class="mb-4">
    History bukti pembayaran yang telah diupload oleh user.
  </p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        History Bukti Pembayaran
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Tipe</th>
              <th>File</th>
              <th>created_at</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Tipe</th>
              <th>File</th>
              <th>created_at</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach ($data as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->user->pegawai->tipe}}</td>
                <td><a href="{{ asset('storage/bukti_transfer/' . $row->bukti_transfer) }}"
                    target="_blank">{{ $row->bukti_transfer }}</a></td>
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
