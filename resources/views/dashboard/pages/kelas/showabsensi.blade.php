@extends('dashboard.layouts.main')

@section('container')

@if(strlen(Request::get('date1')) > 0) 
    @php 
        $date1 = Request::get('date1') 
    @endphp
@endif 

@if(strlen(Request::get('date2')) > 0) 
    @php 
        $date2 = Request::get('date2') 
    @endphp
@endif

    <div class="card" style="border-radius: 15px; margin-bottom: 10px;">
        <div class="card-body">
            <form class="form form-horizontal" id="form">
                <div class="row mb-3">
                    <label class="col-form-label col-md-2">Tanggal</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" class="form-control" name="date1" id="date1" autocomplete="off" value="{{ $date1 }}">
                            <span class="input-group-text">s/d</span>
                            <input type="text" class="form-control" name="date2" id="date2" autocomplete="off" value="{{ $date2 }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-form-label col-md-2"></label>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-primary">Filter</button> 
                        <a href="/absensi/export?id={{$id}}&date1={{$date1}}&date2={{$date2}}" class="btn btn-success">Export</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-condensed table-striped">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2" style="min-width: 280px;">Nama</th>
                            <?php
                            // date2 tambah 1 hari supaya genap jadi sebulan dan bisa filter pada hari itu
                            $date2_query = Date('Y-m-d', strtotime($date2.'+1 days'));

                            // looping per hari diantara 2 tanggal
                            $begin = new DateTime($date1);
                            $end = new DateTime($date2_query);

                            $interval = DateInterval::createFromDateString('1 day');
                            $period = new DatePeriod($begin, $interval, $end);

                            foreach ($period as $dt) {
                                $daynow = $dt->format('l');

                                if($daynow != 'Sunday') {
                                    echo '<th scope="col" colspan="2" class="text-center" style="min-width: 220px;">'.$dt->format("d-m-Y").'</th>';
                                }
                            }
                            ?>
                        </tr>
                        <tr>
                        <?php
                        foreach ($period as $dt) {
                            $daynow = $dt->format('l');

                            if($daynow != 'Sunday') {
                                echo '<th class="text-center">Datang</th>';
                                echo '<th class="text-center">Pulang</th>';
                            }
                        }
                        ?>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $i)
                            <tr>
                                <td valign="top">{{ $loop->iteration }}</td>
                                <td valign="top">{{ $i->user->nama }}</td>
                                <?php
                                // loop data presensi setiap user
                                echo '<pre>';
                                foreach ($presensi[$i->id] as $pKey => $pValue) {
                                    $datang = '';
                                    $pulang = '';

                                    if(strlen($pValue['datang']) > 0) {
                                        $datang = Date('H:i:s', strtotime($pValue['datang']));
                                    }
                                    if(strlen($pValue['pulang']) > 0) {
                                        $pulang = Date('H:i:s', strtotime($pValue['pulang']));
                                    }

                                    if($pValue['status_datang'] == 'Terlambat') {
                                        $datang = '<span class="badge bg-danger">'.$datang.'</span>';
                                    }

                                    // cek jika ada izin di tanggal itu, maka kolom di colspan
                                    if(strlen($pValue['izin']) > 0) {
                                        echo '<td valign="top" colspan="2" align="center">
                                            <span class="badge bg-info">'.$pValue['izin'].'</span>
                                        </td>';

                                    } else {
                                        echo '<td valign="top">'.$datang.'</td>';
                                        echo '<td valign="top">'.$pulang.'</td>';
                                    }
                                }
                                ?>
                            </tr>
                        @endforeach

                        <!-- @foreach ($absensi as $i)
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
                            </tr>
                        @endforeach -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
