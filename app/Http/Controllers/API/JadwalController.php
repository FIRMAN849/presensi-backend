<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as ControllersController;
use App\Helpers\ResponseFormatter;
use App\Models\Izin;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class JadwalController extends ControllersController
{
    public function schedules(Request $request)
    {
        //mengambil data user
        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return response()->json(['message' => 'Siswa not found'], 404);
        }

        //mengambil data jadwal berdasarkan kelas dari user yang login
        $schedule_data = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->get();

        //menampilkan jadwal dengan metode with untuk mengambil data
        //dari tabel lain dan orderby untuk mengurutkan berdasarkan hari dan waktu
        $schedule_data = jadwal::with('kelas', 'mapel', 'guru')
            ->orderBy('hari', 'desc')
            ->orderBy('jam_awal')
            ->get();

        // Query schedule data from the database based on the user's class
        //$schedule_data = Jadwal::where('kelas_id', $user->siswas->kelas)->get();

        // Format query result as JSON
        $schedule_list = [];
        foreach ($schedule_data as $schedule) {
            $schedule_dict = [
                'id' => $schedule->id,
                'hari' => $schedule->hari,
                'mapel_id' => $schedule->mapel->nama_mapel,
                'guru_id' => $schedule->guru->nama_guru,
                'kelas_id' => $schedule->kelas->nama_kelas,
                'jam_awal' => $schedule->jam_awal,
                'jam_akhir' => $schedule->jam_akhir,
            ];
            $schedule_list[] = $schedule_dict;
        }

        // return response()->json($schedule_list);
        return ResponseFormatter::success(
            $schedule_list,
            'Data Jadwal berhasil diambil'
        );
    }

    public function getjadwal($kelas_id)
    {

        // $kelas_id = $request['siswa_id'];

        if (strlen($kelas_id) == 0) {
            return ResponseFormatter::error(
                null,
                'Id kelas tidak valid'
            );
        }

        $history_data = Jadwal::where('kelas_id', $kelas_id)->get();
        // dd($history_data);

        return ResponseFormatter::success(
            $history_data,
            'Berhasil mengambil data Jadwal'
        );

        // $response = [
        //     'status' => 'success',
        //     'message' => 'Data retrieved successfully',
        //     'data' => $history_data,
        // ];

        // return response()->json($response);
    }
}
