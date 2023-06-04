<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date1 = @$request['date1'];
        $date2 = @$request['date2'];
        $kelas_id = @$request['kelas_id'];
        $jenis_absen = @$request['jenis_absen'];

        // jika tidak terisi, tanggal otomatis terfilter satu bulan ini / hari ini
        if (!isset($date1) || strlen($date1) == 0) {
            $date1 = Date('Y-m-01');
        }
        if (!isset($date2) || strlen($date2) == 0) {
            $date2 = Date('Y-m-t');
        }

        // date2 tambah 1 hari supaya genap jadi sebulan dan bisa filter pada hari itu
        $date2_query = Date('Y-m-d', strtotime($date2 . '+1 days'));

        // ambil data absensi
        $absensi = Absensi::whereBetween('tgl_absen', [Date('Y-m-d', strtotime($date1)), Date('Y-m-d', strtotime($date2_query))]);
        // jika filter kelas terisi
        if (strlen($kelas_id) > 0) {
            $absensi->join('siswas', 'absensis.siswa_id', '=', 'siswas.id');
            $absensi->where('kelas_id', $kelas_id);
        }
        // jika filter jenis absen terisi
        if (strlen($jenis_absen) > 0) {
            $absensi->where('jenis_absen', $jenis_absen);
        }
        $absensi = $absensi->get();

        return view('riwayat', [
            'title' => 'Presensi SMKN 2 KRAKSAAN',
            'date1' => Date('d-m-Y', strtotime($date1)),
            'date2' => Date('d-m-Y', strtotime($date2)),
            'kelas' => Kelas::all(),
            'absensi' => $absensi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
