@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="mb-2">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <a href="/siswa/create" class="btn btn-success btn-sm mb-3">
        Tambah Data
    </a>

    <div class="card mb-5" style="border-radius: 15px">
        <div class="card-body">
            <table id="table_siswa" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Userid</th>
                        <th>Nama</th>
                        <th>Nis</th>
                        <th>Kelas</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $std)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $std->user_id }}</td>
                            <td>{{ $std->user->nama }}</td>
                            <td>{{ $std->nis }}</td>
                            <td>{{ $std->kelas->nama_kelas }}</td>
                            <td>{{ $std->tgl_lahir }}</td>
                            <td>{{ $std->jenis_kelamin }}</td>
                            <td>{{ $std->alamat }}</td>
                            <td>{{ $std->email }}</td>
                            <td>
                                <a href="/siswa/{{ $std->id }}/edit" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="/siswa/{{ $std->id }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm border-0"
                                        onclick="return confirm('Are you sure?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="margin: 0 auto">Tambah {{ $title }}
                    </h1>
                </div>
                <div class="modal-body">
                    <form action="/user" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Nama</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Nis</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('nis') is-invalid @enderror"
                                        id="nis" name="nis" value="{{ old('nis') }}">
                                    @error('nis')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Kelas</label>
                                    <select class="form-select" id="kelas">
                                        @foreach ($categories as $kelas)
                                            @if (old('kelas') === $kelas->id)
                                                <option value="{{ $kelas->id }}" selected>{{ $kelas->nama_kelas }}
                                                </option>
                                            @else
                                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Tanggal Lahir</label>
                                    <input type="date"
                                        class="form-control form-control-sm @error('tgl-lahir') is-invalid @enderror"
                                        id="tgl-lahir" name="tgl-lahir" value="{{ old('tgl-lahir') }}">
                                    @error('tgl-lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Alamat</label>
                                    <textarea class="form-control form-control-sm @error('tgl-lahir') is-invalid @enderror" id="alamat" name="alamat"
                                        value="{{ old('alamat') }}"></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis-Kelamin">
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Email</label>
                                    <input type="email"
                                        class="form-control form-control-sm @error('email') is-invalid @enderror"
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
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Role</label>
                                    <select class="form-select" id="jenis Kelamin">
                                        <option value="user">User</option>
                                        <option value="other">Other</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label-sm">Password</label>
                                    <input type="password"
                                        class="form-control form-control-sm @error('password') is-invalid @enderror"
                                        id="password" name="password" value="{{ old('password') }}">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%">TAMBAH</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit {{ $title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>











    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_siswa').DataTable({
                ordering: false,
                responsive: true
            });
        });

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
