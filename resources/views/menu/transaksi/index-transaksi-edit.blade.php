@extends('layouts.default')

@section('main-content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Edit Transaction</h1>

  <!-- Success Message -->
  @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <!-- Error Messages -->
  @if ($errors->any())
    <div class="alert alert-danger border-left-danger" role="alert">
      <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form for Transaction Upload -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <form method="POST" action="{{ route('data-transaksi.update', $data_transaksi->id) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- File Input for Proof of Transfer -->
        <div class="form-group">
          <label for="bukti_transfer">Proof of Transfer</label>
          <input type="file" class="form-control-file" id="bukti_transfer" name="bukti_transfer" accept="image/*"
            onchange="previewImage(this)">
          <!-- Old Image Preview -->
          @if ($data_transaksi->bukti_transfer)
            <small>
              <strong>Old Image:</strong>
            </small>
            <div>
              <img src="{{ asset('storage/bukti_transfer/' . $data_transaksi->bukti_transfer) }}" id="old_preview"
                alt="Old Image Preview" style="max-width: 100%; max-height: 400px;">
            </div>
          @endif
          <!-- New Image Preview -->
          <img id="preview" src="#" alt="New Image Preview"
            style="display: none; max-width: 100%; margin-top: 10px; max-height: 400px;">
        </div>

        <!-- Date Input -->
        <div class="form-group">
          <label for="tanggal">Date</label>
          <input type="date" class="form-control" id="tanggal" name="tanggal"
            value="{{ $data_transaksi->tanggal ?? old('tanggal') }}">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- JavaScript to Handle Image Preview -->
  <script>
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#preview').attr('src', e.target.result).show();
          $('#old_preview').hide(); // Hide old image on selecting new image
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endpush
