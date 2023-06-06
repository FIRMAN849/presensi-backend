<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Izin;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $today = Carbon::today();
        $totalIzin = Izin::whereDate('tgl_izin', $today)->count();
        return view('dashboard.pages.dashboard', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'izin' => $totalIzin,
            'siswa' => $totalSiswa,
            'guru' => $totalGuru
        ]);
    }
}
