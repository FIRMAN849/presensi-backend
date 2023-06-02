<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.qrcode.index', [
            'title' => 'QR Presensi',
            'active' => 'qrcode'
        ]);
    }

    public function datang()
    {
        return view('dashboard.pages.qrcode.datang', [
            'title' => 'QR Presensi',
            'active' => 'qrcode'
        ]);
    }

    public function pulang()
    {
        return view('dashboard.pages.qrcode.pulang', [
            'title' => 'QR Presensi',
            'active' => 'qrcode'
        ]);
    }
}
