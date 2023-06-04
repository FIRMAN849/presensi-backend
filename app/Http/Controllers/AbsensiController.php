<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
// use Request;
use Illuminate\Http\Request;

use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
// use MaatWebsite\Excel;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // $request = Request::all();
        // dd($request);

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

        return view('dashboard.pages.absensi.index', [
            'title' => 'Manajemen Presensi',
            'active' => 'absensi',
            'date1' => Date('d-m-Y', strtotime($date1)),
            'date2' => Date('d-m-Y', strtotime($date2)),
            'kelas' => Kelas::all(),
            'absensi' => $absensi
        ]);
    }

    public function export(Request $request)
    {
        // $request = Request::all();

        // ambil data dari parameter get
        $id = $request['id'];
        $date1 = $request['date1'];
        $date2 = $request['date2'];

        // replace tanggal hilangkan "-"
        $date1 = str_replace('-', '', $date1);
        $date2 = str_replace('-', '', $date2);

        // ambil data nama kelas
        $kelas = Kelas::where('id', $id)->first();
        $nama_kelas = $kelas->nama_kelas;
        // dd($nama_kelas);

        return Excel::download(new AbsensiExport, 'Presensi_' . $nama_kelas . '_' . $date1 . '_' . $date2 . '.xlsx');
    }

    public function destroy(Absensi $absensi)
    {
        //delete absensi
        $absensi->delete();

        //redirect to index
        return redirect('/absensi')->with('success', 'Berhasil menghapus absensi');
    }
}
