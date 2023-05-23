@extends('dashboard.layouts.main')

@section('container')
    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <form action="/mapel" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Kode Mapel</label>
                            <input type="text"
                                class="form-control form-control-sm @error('kode_mapel') is-invalid @enderror"
                                id="kode_mapel" name="kode_mapel" value="{{ old('kode_mapel') }}">
                            @error('kode_mapel')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Nama Mapel</label>
                            <input type="text"
                                class="form-control form-control-sm @error('nama_mapel') is-invalid @enderror"
                                id="nama_mapel" name="nama_mapel" value="{{ old('nama_mapel') }}">
                            @error('nama_mapel')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%">TAMBAH</button>
                <a href="/user" class="btn btn-danger mt-2" style="width: 100%">
                    Batal
                </a>
            </form>
        </div>
    </div>
@endsection
