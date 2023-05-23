@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="mb-2">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <a href="/mapel/create" class="btn btn-success btn-sm mb-3">
        Tambah Data
    </a>

    <div class="card mb-5" style="border-radius: 15px">
        <div class="card-body">
            <table id="table_mapel" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Mapel</th>
                        <th>Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mapel as $mpl)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mpl->kode_mapel }}</td>
                            <td>{{ $mpl->nama_mapel }}</td>
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
            $('#table_mapel').DataTable({
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
