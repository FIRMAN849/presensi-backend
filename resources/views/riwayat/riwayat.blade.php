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

    <!-- DATEPICKER -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <title>{{ $title }}</title>
</head>

<body>

    <div class="container">

        @if (strlen(Request::get('date1')) > 0)
            @php
                $date1 = Request::get('date1');
            @endphp
        @endif

        @if (strlen(Request::get('date2')) > 0)
            @php
                $date2 = Request::get('date2');
            @endphp
        @endif

        <div class="mt-5 mb-5">
            <h3><b>{{ $title }}</b></h3>
        </div>

        <div class="card" style="border-radius: 15px; margin-bottom: 10px;">
            <div class="card-body">
                <form class="form form-horizontal" id="form">
                    <div class="row mb-3">
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
                    <div class="row">
                        <label class="col-form-label col-md-2"></label>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-primary">Filter</button>
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
                                $date2_query = Date('Y-m-d', strtotime($date2 . '+1 days'));

                                // looping per hari diantara 2 tanggal
                                $begin = new DateTime($date1);
                                $end = new DateTime($date2_query);

                                $interval = DateInterval::createFromDateString('1 day');
                                $period = new DatePeriod($begin, $interval, $end);

                                foreach ($period as $dt) {
                                    $daynow = $dt->format('l');

                                    if ($daynow != 'Sunday' && $daynow != 'Saturday') {
                                        echo '<th scope="col" colspan="2" class="text-center" style="min-width: 220px;">' . $dt->format('d-m-Y') . '</th>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                foreach ($period as $dt) {
                                    $daynow = $dt->format('l');

                                    if ($daynow != 'Sunday' && $daynow != 'Saturday') {
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

                                        if (strlen($pValue['datang']) > 0) {
                                            $datang = Date('H:i:s', strtotime($pValue['datang']));
                                        }
                                        if (strlen($pValue['pulang']) > 0) {
                                            $pulang = Date('H:i:s', strtotime($pValue['pulang']));
                                        }

                                        if ($pValue['status_datang'] == 'Terlambat') {
                                            $datang = '<span class="badge bg-danger">' . $datang . '</span>';
                                        }

                                        // cek jika ada izin di tanggal itu, maka kolom di colspan
                                        if (strlen($pValue['izin']) > 0) {
                                            echo '<td valign="top" colspan="2" align="center">
                                                                                                                                                                                                                                                                                                                                                    <span class="badge bg-info">' .
                                                $pValue['izin'] .
                                                '</span>
                                                                                                                                                                                                                                                                                                                                                </td>';
                                        } else {
                                            echo '<td valign="top">' . $datang . '</td>';
                                            echo '<td valign="top">' . $pulang . '</td>';
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

        <div class="mt-2">
            <a href="/presensismkn2kraksaan">Kembali</a>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const navbar = document.querySelector('.col-navbar')
        const cover = document.querySelector('.screen-cover')

        const sidebar_items = document.querySelectorAll('.sidebar-item')

        function toggleNavbar() {
            navbar.classList.toggle('d-none')
            cover.classList.toggle('d-none')
        }

        function toggleActive(e) {
            sidebar_items.forEach(function(v, k) {
                v.classList.remove('active')
            })
            e.closest('.sidebar-item').classList.add('active')

        }

        $(document).ready(function() {
            $("#date1").datepicker({
                dateFormat: "dd-mm-yy"
            });
            $("#date2").datepicker({
                dateFormat: "dd-mm-yy"
            });
        });
    </script>

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
