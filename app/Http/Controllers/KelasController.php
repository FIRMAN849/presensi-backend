<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Izin;
// use Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.kelas.index', [
            'title' => 'Kelas',
            'active' => 'kelas',
            'kelas' => Kelas::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.kelas.create', [
            'title' => 'Tambah Kelas',
            'active' => 'kelas',
            'kelas' => Kelas::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKelasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKelasRequest $request)
    {
        $data = $request->all();

        Kelas::create($data);
        // $validedData = $request->validate([
        //     'nama_kelas' => 'required'
        // ]);

        // Kelas::create($validedData);

        return redirect('/kelas')->with('success', 'Berhasil menambahkan kelas');
    }

    public function siswa($id)
    {
        // return Siswa::find($id);

        $nama = 'asc';
        $siswa = Siswa::join('users', 'siswas.user_id', '=', 'users.id')
            ->where('siswas.kelas_id', $id)
            ->orderBy('users.nama', $nama)
            ->get();

        // $siswa = DB::table('siswas')
        //     ->join('users', 'siswas.kelas_id', '=', 'users.id')
        //     ->where('siswas.kelas_id', $id)
        //     ->orderBy('users.nama')
        //     ->get();



        return view('dashboard.pages.kelas.showsiswa', [
            'title' => 'Siswa',
            'active' => 'kelas',
            'students' => $siswa
        ]);
    }

    public function jadwal($id)
    {
        //  return Jadwal::find($id);
        $jadwalKelas = Jadwal::where('kelas_id', $id)
            ->orderBy('hari', 'desc')
            ->orderBy('jam_awal')
            ->get();

        return view('dashboard.pages.kelas.showjadwal', [
            'title' => 'Jadwal Kelas',
            'active' => 'kelas',
            'jadwal' => $jadwalKelas
        ]);
    }

    public function absensi($id, Request $request)
    {
        // $request = Request::all();
        // dd($request);

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
        // echo '<pre>';
        foreach ($siswaKelas as $sValue) {
            // var_dump($sValue);
            $arrPresensi[$sValue->id] = array();

            foreach ($period as $key => $dt) {
                $daynow = $dt->format('l');

                if($daynow != 'Sunday') {
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
                    foreach($checkAbsensi as $caKey => $caValue) {
                        if($caValue->jenis_absen == 'presensi_datang') {
                            $arrPresensi[$sValue->id][$key]['datang'] = $caValue->tgl_absen;
                            $arrPresensi[$sValue->id][$key]['status_datang'] = $caValue->status;
                        }
                        if($caValue->jenis_absen == 'presensi_pulang') {
                            $arrPresensi[$sValue->id][$key]['pulang'] = $caValue->tgl_absen;
                            $arrPresensi[$sValue->id][$key]['status_pulang'] = $caValue->status;
                        }
                    }

                    // ambil data izin berdasarkan siswa dan looping tanggal
                    $checkIzin = Izin::where('siswa_id', $sValue->id)
                        ->where('status', 'Accept')
                        ->whereDate('tgl_izin', $dt->format("Y-m-d"))
                        ->get();
                    foreach($checkIzin as $ciKey => $ciValue) {
                        $arrPresensi[$sValue->id][$key]['izin'] = $ciValue->keterangan;
                    } 
                }
            }
        }
        // dd($arrPresensi);

        $kelas = Kelas::where('id', $id)->first();
        $nama_kelas = $kelas->nama_kelas;

        return view('dashboard.pages.kelas.showabsensi', [
            'title' => 'Presensi Kelas ' . $nama_kelas,
            'active' => 'kelas',
            'id' => $id,
            'date1' => Date('d-m-Y', strtotime($date1)),
            'date2' => Date('d-m-Y', strtotime($date2)),
            'absensi' => $absensiKelas,
            'siswa' => $siswaKelas,
            'presensi' => $arrPresensi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas, $id)
    {
        // return Jadwal::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKelasRequest  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        //
    }
}
