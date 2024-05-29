@extends('layouts.default')

@section('main-content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">
    Create New Transaksi
  </h1>

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

  <div class="card shadow mb-4">
    <div class="card-body">
      <form method="POST" action="{{ route('upload-transaksi.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="bukti_transfer">Bukti Transfer</label>
          <input type="file" class="form-control-file" id="bukti_transfer" name="bukti_transfer" accept="image/*"
            onchange="previewImage(this)" value="{{ old('bukti_transfer') }}">
          <img id="preview" src="#" alt="Image Preview"
            style="display: none; max-width: 100%; margin-top: 10px; max-height: 400px;">
        </div>

        <div class="form-group">
          <label for="tanggal">Tanggal</label>
          <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#preview').attr('src', e.target.result).show();
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endpush
