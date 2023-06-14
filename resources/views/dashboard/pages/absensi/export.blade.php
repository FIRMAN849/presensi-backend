<table style="border: 1px solid #000;">
    <thead>
        <tr>
            <th><b>Presensi Kelas {{ $nama_kelas }}</b></th>
        </tr>
        <tr>
            <th rowspan="2" align="center" width="30px">#</th>
            <th rowspan="2" width="280px">Nama</th>
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
                    echo '<th colspan="2" align="center" width="180px">' . $dt->format('d-m-Y') . '</th>';
                }
            }
            ?>
            <td align="center" colspan="3">Total</td>
        </tr>
        <tr>
            <?php
            foreach ($period as $dt) {
                $daynow = $dt->format('l');

                if ($daynow != 'Sunday' && $daynow != 'Saturday') {
                    echo '<th align="center" width="90px">Datang</th>';
                    echo '<th align="center" width="90px">Pulang</th>';
                }
            }
            ?>

            <td align="center">Izin</td>
            <td align="center">Sakit</td>
            <td align="center">Alpha</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $i)
            <tr>
                <td valign="top" align="center">{{ $loop->iteration }}</td>
                <td valign="top">{{ $i->user->nama }}</td>
                <?php
                // loop data presensi setiap user
                echo '<pre>';
                foreach ((array) $presensi[$i->id] as $pKey => $pValue) {
                    $datang = '';
                    $pulang = '';

                    if (strlen($pValue['datang']) > 0) {
                        $datang = Date('H:i:s', strtotime($pValue['datang']));
                    }
                    if (strlen($pValue['pulang']) > 0) {
                        $pulang = Date('H:i:s', strtotime($pValue['pulang']));
                    }

                    $s_datang = '';
                    if ($pValue['status_datang'] == 'Terlambat') {
                        $s_datang = 'style="background-color:red;color:white;"';
                    }

                    $s_pulang = '';

                    // cek jika ada izin di tanggal itu, maka kolom di colspan
                    if (strlen($pValue['izin']) > 0) {
                        echo '<td valign="top" colspan="2" align="center" style="background-color:blue;color:white;">' . $pValue['izin'] . '</td>';
                    } else {
                        echo '<td valign="top" align="center" ' . $s_datang . '>' . $datang . '</td>';
                        echo '<td valign="top" align="center" ' . $s_pulang . '>' . $pulang . '</td>';
                    }
                }
                ?>
                <td align="center">{{ $total_izin[$i->id] }}</td>
                <td align="center">{{ $total_sakit[$i->id] }}</td>
                <td align="center">{{ $total_alpha[$i->id] }}</td>
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
