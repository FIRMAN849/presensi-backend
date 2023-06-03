@extends('dashboard.layouts.main')

@section('container')
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
                            <input type="text" class="form-control" name="date1" id="date1" autocomplete="off"
                                value="{{ $date1 }}">
                            <span class="input-group-text">s/d</span>
                            <input type="text" class="form-control" name="date2" id="date2" autocomplete="off"
                                value="{{ $date2 }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-form-label col-md-2">Kelas</label>
                    <div class="col-md-5">
                        <select class="form-control" name="kelas_id" id="kelas_id">
                            <option value="">Semua</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" @if ($kelas_id == $k->id) selected @endif>
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
                            <option value="presensi_datang" @if ($jenis_absen == 'presensi_datang') selected @endif>Presensi
                                Datang</option>
                            <option value="presensi_pulang" @if ($jenis_absen == 'presensi_pulang') selected @endif>Presensi
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
                                        onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
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
@endsection
