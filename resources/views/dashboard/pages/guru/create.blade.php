@extends('dashboard.layouts.main')

@section('container')
    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <form action="/guru" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Nama Guru</label>
                            <input type="text"
                                class="form-control form-control-sm @error('nama_guru') is-invalid @enderror" id="nama_guru"
                                name="nama_guru" value="{{ old('nama_guru') }}">
                            @error('nama_guru')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">NIP</label>
                            <input type="text" class="form-control form-control-sm @error('nip') is-invalid @enderror"
                                id="nip" name="nip" value="{{ old('nip') }}">
                            @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Jenis_Kelamin</label>
                            <select class="form-select" name="jenis_kelamin">
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Alamat</label>
                            <textarea class="form-control form-control-sm @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                value="{{ old('alamat') }}"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%">TAMBAH</button>
                <a href="/guru" class="btn btn-danger mt-2" style="width: 100%">
                    Batal
                </a>
            </form>
        </div>
    </div>
@endsection
