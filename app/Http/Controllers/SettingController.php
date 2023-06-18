<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $check_pdsj1 = DB::table('config')->where(['key' => 'presensi_datang_seninjumat1']);
        if($check_pdsj1->count() == 0) {
            $presensi_datang_seninjumat1 = '06:00:00';

            DB::table('config')->insert([
                'key' => 'presensi_datang_seninjumat1',
                'value' => $presensi_datang_seninjumat1
            ]);
        } else {
            $presensi_datang_seninjumat1 = $check_pdsj1->first()->value;
        }

        $check_pdsj2 = DB::table('config')->where(['key' => 'presensi_datang_seninjumat2']);
        if($check_pdsj2->count() == 0) {
            $presensi_datang_seninjumat2 = '08:00:00';

            DB::table('config')->insert([
                'key' => 'presensi_datang_seninjumat2',
                'value' => $presensi_datang_seninjumat2
            ]);
        } else {
            $presensi_datang_seninjumat2 = $check_pdsj2->first()->value;
        }

        $check_ppsk1 = DB::table('config')->where(['key' => 'presensi_pulang_seninkamis1']);
        if($check_ppsk1->count() == 0) {
            $presensi_pulang_seninkamis1 = '15:00:00';

            DB::table('config')->insert([
                'key' => 'presensi_pulang_seninkamis1',
                'value' => $presensi_pulang_seninkamis1
            ]);
        } else {
            $presensi_pulang_seninkamis1 = $check_ppsk1->first()->value;
        }

        $check_ppsk2 = DB::table('config')->where(['key' => 'presensi_pulang_seninkamis2']);
        if($check_ppsk2->count() == 0) {
            $presensi_pulang_seninkamis2 = '17:00:00';

            DB::table('config')->insert([
                'key' => 'presensi_pulang_seninkamis2',
                'value' => $presensi_pulang_seninkamis2
            ]);
        } else {
            $presensi_pulang_seninkamis2 = $check_ppsk2->first()->value;
        }

        $check_ppj1 = DB::table('config')->where(['key' => 'presensi_pulang_jumat1']);
        if($check_ppj1->count() == 0) {
            $presensi_pulang_jumat1 = '10:45:00';

            DB::table('config')->insert([
                'key' => 'presensi_pulang_jumat1',
                'value' => $presensi_pulang_jumat1
            ]);
        } else {
            $presensi_pulang_jumat1 = $check_ppj1->first()->value;
        }

        $check_ppj2 = DB::table('config')->where(['key' => 'presensi_pulang_jumat2']);
        if($check_ppj2->count() == 0) {
            $presensi_pulang_jumat2 = '12:00:00';

            DB::table('config')->insert([
                'key' => 'presensi_pulang_jumat2',
                'value' => $presensi_pulang_jumat2
            ]);
        } else {
            $presensi_pulang_jumat2 = $check_ppj2->first()->value;
        }

        $check_latlong = DB::table('config')->where(['key' => 'location_latlong']);
        if($check_latlong->count() == 0) {
            $location_latlong = '-7.7646547,113.4185951';

            DB::table('config')->insert([
                'key' => 'location_latlong',
                'value' => $location_latlong
            ]);
        } else {
            $location_latlong = $check_latlong->first()->value;
        }

        $check_maxradius = DB::table('config')->where(['key' => 'max_radius']);
        if($check_maxradius->count() == 0) {
            $max_radius = '50';

            DB::table('config')->insert([
                'key' => 'max_radius',
                'value' => $max_radius
            ]);
        } else {
            $max_radius = $check_maxradius->first()->value;
        }


        $arr_data['presensi_datang_seninjumat1'] = $presensi_datang_seninjumat1;
        $arr_data['presensi_datang_seninjumat2'] = $presensi_datang_seninjumat2;
        $arr_data['presensi_pulang_seninkamis1'] = $presensi_pulang_seninkamis1;
        $arr_data['presensi_pulang_seninkamis2'] = $presensi_pulang_seninkamis2;
        $arr_data['presensi_pulang_jumat1'] = $presensi_pulang_jumat1;
        $arr_data['presensi_pulang_jumat2'] = $presensi_pulang_jumat2;
        $arr_data['location_latlong'] = $location_latlong;
        $arr_data['max_radius'] = $max_radius;

        return view('dashboard.pages.setting.index', [
            'title' => 'Pengaturan',
            'active' => 'setting',
            'data' => $arr_data
        ]);
    }

}
