@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="mb-2">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="card mb-5" style="border-radius: 15px">
        <div class="card-body">
            <form action="/setting/save" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3" style="width: 40%">
                    <label class="col-form-label-sm">Waktu Presensi Datang Hari Senin~Jumat</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control text-center form-control-sm @error('presensi_datang_seninjumat1') is-invalid @enderror" id="presensi_datang_seninjumat1"
                        name="presensi_datang_seninjumat1" value="{{ $data['presensi_datang_seninjumat1'] }}">
                        <span class="input-group-text">s/d</span>
                        <input type="text" class="form-control text-center form-control-sm @error('presensi_datang_seninjumat2') is-invalid @enderror" id="presensi_datang_seninjumat2"
                        name="presensi_datang_seninjumat2" value="{{ $data['presensi_datang_seninjumat2'] }}">
                    </div>
                </div>
                <div class="mb-3" style="width: 40%">
                    <label class="col-form-label-sm">Waktu Presensi Pulang Hari Senin~Kamis</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control text-center form-control-sm @error('presensi_pulang_seninkamis1') is-invalid @enderror" id="presensi_pulang_seninkamis1"
                        name="presensi_pulang_seninkamis1" value="{{ $data['presensi_pulang_seninkamis1'] }}">
                        <span class="input-group-text">s/d</span>
                        <input type="text" class="form-control text-center form-control-sm @error('presensi_pulang_seninkamis2') is-invalid @enderror" id="presensi_pulang_seninkamis2"
                        name="presensi_pulang_seninkamis2" value="{{ $data['presensi_pulang_seninkamis2'] }}">
                    </div>
                </div>
                <div class="mb-3" style="width: 40%">
                    <label class="col-form-label-sm">Waktu Presensi Pulang Hari Jumat</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control text-center form-control-sm @error('presensi_pulang_jumat1') is-invalid @enderror" id="presensi_pulang_jumat1"
                        name="presensi_pulang_jumat1" value="{{ $data['presensi_pulang_jumat1'] }}">
                        <span class="input-group-text">s/d</span>
                        <input type="text" class="form-control text-center form-control-sm @error('presensi_pulang_jumat2') is-invalid @enderror" id="presensi_pulang_jumat2"
                        name="presensi_pulang_jumat2" value="{{ $data['presensi_pulang_jumat2'] }}">
                    </div>
                </div>
                <div class="mb-3" style="width: 40%">
                    <label class="col-form-label-sm">Koordinat Sekolah (Latitude,Longitude)</label>
                    <input type="text" class="form-control form-control-sm @error('location_latlong') is-invalid @enderror" id="location_latlong"
                        name="location_latlong" value="{{ $data['location_latlong'] }}">
                </div>
                <div class="mb-3" style="width: 40%">
                    <label class="col-form-label-sm">Maksimal Radius Presensi</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control form-control-sm @error('max_radius') is-invalid @enderror" id="max_radius"
                            name="max_radius" value="{{ $data['max_radius'] }}">
                        <span class="input-group-text">meter</span>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">SIMPAN</button>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
        });
    </script>
@endsection
