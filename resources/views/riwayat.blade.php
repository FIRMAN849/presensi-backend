<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/datatables.min.css">

    <title>{{ $title }}</title>
</head>

<body>

    <div class="container">

        <div class="mt-5 mb-5">
            <h3><b>{{ $title }}</b></h3>
        </div>
        @php
            $kelas_id = Request::get('kelas_id');
            $jenis_absen = Request::get('jenis_absen');
        @endphp

        @if (session()->has('success'))
            <div class="mb-2">
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="card" style="border-radius: 15px; margin-bottom: 10px;">
            <div class="card-body">
                <form class="form form-horizontal" id="form">
                    <div class="row mb-2">
                        <label class="col-form-label col-md-2">Tanggal</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control" name="date1" id="date1"
                                    autocomplete="off" value="{{ $date1 }}">
                                <span class="input-group-text">s/d</span>
                                <input type="text" class="form-control" name="date2" id="date2"
                                    autocomplete="off" value="{{ $date2 }}">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-form-label col-md-2">Kelas</label>
                        <div class="col-md-5">
                            <select class="form-control" name="kelas_id" id="kelas_id">
                                <option value="">Semua</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}"
                                        @if ($kelas_id == $k->id) selected @endif>
                                        {{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label col-md-2">Jenis Presensi</label>
                        <div class="col-md-5">
                            <select class="form-control" name="jenis_absen" id="jenis_absen">
                                <option value="">Semua</option>
                                <option value="presensi_datang" @if ($jenis_absen == 'presensi_datang') selected @endif>
                                    Presensi
                                    Datang</option>
                                <option value="presensi_pulang" @if ($jenis_absen == 'presensi_pulang') selected @endif>
                                    Presensi
                                    Pulang</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-form-label col-md-2"></label>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-5" style="border-radius: 15px">
            <div class="card-body">
                <table id="table_absensi" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jenis Absen</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $i)
                            <tr>
                                <td valign="top">{{ $loop->iteration }}</td>
                                <td valign="top">{{ $i->siswa->user->nama }}</td>
                                <td valign="top">{{ ucwords(str_replace('_', ' ', $i->jenis_absen)) }}</td>
                                <td valign="top">{{ $i->tgl_absen }}</td>
                                <td valign="top">
                                    @if ($i->status == 'Late')
                                        <span class="badge bg-danger">{{ $i->status }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $i->status }}</span>
                                    @endif
                                </td>
                                <td valign="top">
                                    <form action="/absensi/{{ $i->id }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm border-0"
                                            onclick="return confirm('Are you sure?')"><i
                                                class="bx bx-trash"></i></button>
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
                $('#table_absensi').DataTable({
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
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>


    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
