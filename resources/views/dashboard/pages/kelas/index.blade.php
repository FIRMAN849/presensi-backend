@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="mb-2">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <a href="/kelas/create" class="btn btn-success btn-sm mb-3">
        Tambah Data
    </a>

    <div class="card mb-5" style="border-radius: 15px">
        <div class="card-body">
            <table id="table_kelas" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas as $kls)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kls->nama_kelas }}</td>
                            <td>
                                <a href="/kelas/siswa/{{ $kls->id }}" class="btn btn-warning btn-sm">Siswa</a>
                                <a href="/kelas/jadwal/{{ $kls->id }}" class="btn btn-primary btn-sm">Jadwal</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->












    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_kelas').DataTable({
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
