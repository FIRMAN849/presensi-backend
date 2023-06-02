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
            <div class="row text-center" style="margin-top: 15px;">
                <div class="col-md-6">
                    <h4>Presensi Datang</h4>
                    <img style="height: 300px; width: 300px;" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=smkn2kraksaan,presensi_datang">
                    <div>
                        <a href="/qrcode/datang" target="_blank" class="btn btn-primary">Cetak QR</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Presensi Pulang</h4>
                    <img style="height: 300px; width: 300px;" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=smkn2kraksaan,presensi_pulang">
                    <div>
                        <a href="/qrcode/pulang" target="_blank" class="btn btn-primary">Cetak QR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
