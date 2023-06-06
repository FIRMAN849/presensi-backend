<?php

namespace App\Exports;

use Illuminate\Http\Request;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Izin;
use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{
    public function view(): View
    {
        $request = Request::all();
        // dd($request);

        $id = @$request['id'];
        $date1 = @$request['date1'];
        $date2 = @$request['date2'];

        // jika tidak terisi, tanggal otomatis terfilter satu bulan ini / hari ini
        if (!isset($date1) || strlen($date1) == 0) {
            $date1 = Date('Y-m-d');
        }
        if (!isset($date2) || strlen($date2) == 0) {
            $date2 = Date('Y-m-d');
        }

        // date2 tambah 1 hari supaya genap jadi sebulan dan bisa filter pada hari itu
        $date2_query = Date('Y-m-d', strtotime($date2 . '+1 days'));

        //  return Absensi::find($id);
        $absensiKelas = Absensi::where('siswas.kelas_id', $id)
            ->whereBetween('tgl_absen', [Date('Y-m-d', strtotime($date1)), Date('Y-m-d', strtotime($date2_query))])
            ->join('siswas', 'siswas.id', '=', 'absensis.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
            ->get();

        // ambil data nama kelas
        $kelas = Kelas::where('id', $id)->first();
        $nama_kelas = $kelas->nama_kelas;

        // ambil data siswa berdasarkan kelas
        $siswaKelas = Siswa::where('kelas_id', $id)->get();
        // $totalSiswa = Siswa::where('kelas_id', $id)->count();
        // var_dump($totalSiswa);

        // ambil data absen berdasarkan periode tanggal
        // looping per hari diantara 2 tanggal
        $begin = new \DateTime($date1);
        $end = new \DateTime($date2_query);

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);

        // deklarasi variabel array untuk simpan data absen
        $arrPresensi = array();
        $totalIzin = array();
        $totalSakit = array();
        // echo '<pre>';
        foreach ($siswaKelas as $sValue) {
            // var_dump($sValue);
            $arrPresensi[$sValue->id] = array();
            $totalIzin[$sValue->id] = 0;
            $totalSakit[$sValue->id] = 0;

            foreach ($period as $key => $dt) {
                $daynow = $dt->format('l');

                if ($daynow != 'Sunday' && $daynow != 'Saturday') {
                    $arrPresensi[$sValue->id][] = array(
                        'tanggal' => $dt->format("Y-m-d"),
                        'datang' => null,
                        'status_datang' => null,
                        'pulang' => null,
                        'status_pulang' => null,
                        'izin' => null,
                    );

                    // ambil data absensi berdasarkan siswa dan looping tanggal
                    $checkAbsensi = Absensi::where('siswa_id', $sValue->id)
                        ->whereDate('tgl_absen', $dt->format("Y-m-d"))
                        ->get();
                    foreach ($checkAbsensi as $caKey => $caValue) {
                        if ($caValue->jenis_absen == 'presensi_datang') {
                            $arrPresensi[$sValue->id][$key]['datang'] = $caValue->tgl_absen;
                            $arrPresensi[$sValue->id][$key]['status_datang'] = $caValue->status;
                        }
                        if ($caValue->jenis_absen == 'presensi_pulang') {
                            $arrPresensi[$sValue->id][$key]['pulang'] = $caValue->tgl_absen;
                            $arrPresensi[$sValue->id][$key]['status_pulang'] = $caValue->status;
                        }
                    }

                    // ambil data izin berdasarkan siswa dan looping tanggal
                    $checkIzin = Izin::where('siswa_id', $sValue->id)
                        ->where('status', 'Accept')
                        ->whereDate('tgl_izin', $dt->format("Y-m-d"))
                        ->get();
                    foreach ($checkIzin as $ciKey => $ciValue) {
                        if ($ciValue->keterangan == 'IZIN') {
                            $totalIzin[$sValue->id]++;
                        } else if ($ciValue->keterangan == 'SAKIT') {
                            $totalIzin[$sValue->id]++;
                        }

                        $arrPresensi[$sValue->id][$key]['izin'] = $ciValue->keterangan;
                    }
                }
            }
        }
        // dd($arrPresensi);

        return view('dashboard.pages.absensi.export', [
            'date1' => Date('d-m-Y', strtotime($date1)),
            'date2' => Date('d-m-Y', strtotime($date2)),
            'nama_kelas' => $nama_kelas,
            'absensi' => $absensiKelas,
            'siswa' => $siswaKelas,
            'presensi' => $arrPresensi,
            'total_izin' => $totalIzin,
            'total_sakit' => $totalSakit
        ]);
    }
}
