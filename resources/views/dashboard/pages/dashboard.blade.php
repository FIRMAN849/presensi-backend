@extends('dashboard.layouts.main')

@section('container')
    <div class="row">

        <div class="col-12 col-md-6 col-lg-4">
            <div class="statistics-card"
                style="box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);
            -webkit-box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);
            -moz-box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);">

                <div class="text-center">
                    <h3><B>Data Siswa</B></h3>
                    <h3>{{ $siswa }}</h3>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="statistics-card"
                style="box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);
            -webkit-box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);
            -moz-box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);">

                <div class="text-center">
                    <h3><B>Data Guru</B></h3>
                    <h3>{{ $guru }}</h3>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="statistics-card"
                style="box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);
            -webkit-box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);
            -moz-box-shadow: 1px 7px 10px 0px rgba(0,0,0,0.10);">

                <div class="text-center">
                    <h3><B>Izin Hari Ini</B></h3>
                    <h3>{{ $izin }}</h3>
                </div>

            </div>
        </div>



    </div>
@endsection
