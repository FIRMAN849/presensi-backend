<?php


namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller as ControllersController;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    // public function index()
    // {
    //     return 'test';
    // }

    public function presensi(Request $request)
    {
        // var_dump('presensi');

        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'jenis_absen' => 'required'
        ]);
        // dd($validatedData);

        if ($validatedData['jenis_absen'] != 'smkn2kraksaan,presensi_datang' && $validatedData['jenis_absen'] != 'smkn2kraksaan,presensi_pulang') {
            return ResponseFormatter::error(
                null,
                'Jenis Absen tidak valid'
            );
        }

        $jenis_absen = str_replace('smkn2kraksaan,', '', $validatedData['jenis_absen']);
        $status = '';

        $now = Date('Y-m-d H:i:s');
        $datenow = Date('Y-m-d');
        $daynow = Date('l');
        $timenow = Date('H:i:s');

        // cek apakah user sudah presensi atau belum hari ini
        $check = DB::table('absensis')->where(['siswa_id' => $validatedData['siswa_id'], 'jenis_absen' => $jenis_absen])->whereDate('tgl_absen', $datenow)->count();
        if ($check > 0) {
            return ResponseFormatter::error(
                null,
                'Anda sudah ' . str_replace('_', ' ', $jenis_absen) . ' hari ini'
            );
        }

        // validasi jika presensi_pulang tetapi belum presensi_datang
        if ($jenis_absen == 'presensi_pulang') {
            $check2 = DB::table('absensis')->where(['siswa_id' => $validatedData['siswa_id'], 'jenis_absen' => 'presensi_datang'])->whereDate('tgl_absen', $datenow)->count();
            if ($check2 == 0) {
                return ResponseFormatter::error(
                    null,
                    'Anda belum presensi datang hari ini, gagal untuk presensi pulang'
                );
            }
        }


        // datang senin~jumat jam 06.00-08.00
        $timeDatangSeninJumat1 = Date('H:i:s', strtotime('06:00:00'));
        $timeDatangSeninJumat2 = Date('H:i:s', strtotime('08:00:00'));

        // pulang senin~kamis jam 15.00-17.00
        $timePulangSeninKamis1 = Date('H:i:s', strtotime('15:00:00'));
        $timePulangSeninKamis2 = Date('H:i:s', strtotime('17:00:00'));

        // pulang jumat 10.45-12.00
        $timePulangJumat1 = Date('H:i:s', strtotime('10:45:00'));
        $timePulangJumat2 = Date('H:i:s', strtotime('12:00:00'));

        if (in_array($daynow, array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'))) {
            if ($jenis_absen == 'presensi_datang') {
                // datang senin~jumat
                if ($timenow >= $timeDatangSeninJumat1 && $timenow <= $timeDatangSeninJumat2) {
                    $status = 'Tepat Waktu';
                } else {
                    if ($timenow <= $timeDatangSeninJumat1) {
                        $status = 'Tepat Waktu';
                    } else {
                        $status = 'Terlambat';
                    }
                }
            }

            if ($jenis_absen == 'presensi_pulang') {
                if ($daynow != 'Friday') {
                    // jika bukan hari jumat
                    if ($timenow >= $timePulangSeninKamis1 && $timenow <= $timePulangSeninKamis2) {
                        $status = 'Tepat Waktu';
                    } else {
                        if ($timenow >= $timePulangSeninKamis2) {
                            $status = 'Tepat Waktu';
                        } else {
                            $status = 'Lebih Awal';
                        }
                    }
                } else {
                    // jika jumat
                    if ($timenow >= $timePulangJumat1 && $timenow <= $timePulangJumat2) {
                        $status = 'Tepat Waktu';
                    } else {
                        $status = 'Lebih Awal';
                    }
                }
            }
        } else {
            // sabtu~minggu libur
            return ResponseFormatter::error(
                null,
                'Hari ini hari libur, presensi anda tidak masuk'
            );
        }

        $absensi = new Absensi();
        $absensi->fill($validatedData);
        $absensi->jenis_absen = $jenis_absen;
        $absensi->tgl_absen = $now;
        $absensi->status = $status;
        $absensi->save();
        // $result = $absensi->save();

        $message = 'Presensi berhasil';
        if ($status == 'Terlambat') {
            $message = 'Presensi berhasil, anda terlambat datang hari ini';
        } else if ($status == 'Lebih Awal') {
            $message = 'Presensi berhasil, anda pulang lebih awal hari ini';
        }

        return ResponseFormatter::success(
            $absensi,
            $message
        );

        // if ($result) {
        //     return response()->json(['success' => true]);
        // } else {
        //     return response()->json(['success' => false]);
        // }
    }

    public function history($siswa_id)
    {
        // var_dump('history');

        // ambil data dari parameter get
        // $siswa_id = $request['siswa_id'];

        if (strlen($siswa_id) == 0) {
            return ResponseFormatter::error(
                null,
                'ID Siswa tidak valid'
            );
        }

        $history_data = Absensi::where('siswa_id', $siswa_id)->get();
        // dd($history_data);

        return ResponseFormatter::success(
            $history_data,
            'Berhasil mengambil riwayat presensi'
        );
    }
}
