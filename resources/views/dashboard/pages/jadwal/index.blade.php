@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="mb-2">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <a href="/jadwal/create" class="btn btn-success btn-sm mb-3">
        Tambah Data
    </a>

    <div class="card mb-5" style="border-radius: 15px">
        <div class="card-body">
            <table id="table_jadwal" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hari</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Jam Awal</th>
                        <th>Jam Akhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $jwl)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jwl->hari }}</td>
                            <td>{{ $jwl->mapel->nama_mapel }}</td>
                            <td>{{ $jwl->guru->nama_guru }}</td>
                            <td>{{ $jwl->kelas->nama_kelas }}</td>
                            <td>{{ \Carbon\Carbon::parse($jwl->jam_awal)->locale('id')->isoFormat('HH:mm') }}</td>
                            <td>{{ \Carbon\Carbon::parse($jwl->jam_akhir)->locale('id')->isoFormat('HH:mm') }}</td>
                            <td>
                                <a href="/jadwal/{{ $jwl->id }}/edit" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="/jadwal/{{ $jwl->id }}" method="POST" class="d-inline">
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











    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_jadwal').DataTable({
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
