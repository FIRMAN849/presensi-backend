@extends('dashboard.layouts.main')

@section('container')
    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <form action="/siswa" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Nama</label>
                            <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Username</label>
                            <input type="text"
                                class="form-control form-control-sm @error('username') is-invalid @enderror" id="username"
                                name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">NIS</label>
                            <input type="text" class="form-control form-control-sm @error('nis') is-invalid @enderror"
                                id="nis" name="nis" value="{{ old('nis') }}">
                            @error('nis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Kelas</label>
                            <select class="form-select" name="kelas">
                                @foreach ($categories as $kelas)
                                    @if (old('kelas') === $kelas->id)
                                        <option value="{{ $kelas->id }}" selected>{{ $kelas->nama_kelas }}</option>
                                    @else
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Tanggal Lahir</label>
                            <input type="date"
                                class="form-control form-control-sm @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir"
                                name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                            @error('tgl_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Jenis Kelamin</label>
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
                        <div class="mb-3">
                            <label class="col-form-label-sm">Email</label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="image" class="col-form-label-sm">Image</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5" alt="">
                            <input class="form-control form-control-sm @error('image') is-invalid @enderror" type="file" id="image"
                                name="image" onchange="previewImage()">
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="mb-3">
                            <label class="col-form-label-sm">Role</label>
                            <select class="form-select" name="role">
                                <option value="user">User</option>
                                <option value="other">Other</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label class="col-form-label-sm">Password</label>
                            <input type="password"
                                class="form-control form-control-sm @error('password') is-invalid @enderror" id="password"
                                name="password" value="{{ old('password') }}">
                            @error('password')
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
