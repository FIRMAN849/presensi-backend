@extends('dashboard.layouts.main')

@section('container')
<form action="/kelas" method="POST" enctype="multipart/form-data">
@csrf
<div class="mb-3" style="width: 30%">
    <label class="col-form-label-sm">Nama Kelas</label>
    <input type="text" class="form-control form-control-sm @error('nama_kelas') is-invalid @enderror" id="nama_kelas"
        name="nama_kelas" value="{{ old('nama_kelas') }}">
    @error('nama_kelas')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<button type="submit" class="btn btn-success">TAMBAH</button>
</form>
@endsection