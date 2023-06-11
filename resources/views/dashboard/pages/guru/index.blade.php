@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="mb-2">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <a href="/guru/create" class="btn btn-success btn-sm mb-3">
        Tambah Data
    </a>

    <div class="card mb-5" style="border-radius: 15px">
        <div class="card-body">
            <table id="table_guru" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guru as $gr)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $gr->nip }}</td>
                            <td>{{ $gr->nama_guru }}</td>
                            <td>{{ $gr->jenis_kelamin }}</td>
                            <td>{{ $gr->alamat }}</td>
                            <td>
                                <form action="/guru/{{ $gr->id }}" method="POST" class="d-inline">
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












    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_guru').DataTable({
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
