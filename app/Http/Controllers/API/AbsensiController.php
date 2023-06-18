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
            'jenis_absen' => 'required',
            'location' => 'required',
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

        // ambil data pengaturan
        $check_pdsj1 = DB::table('config')->where(['key' => 'presensi_datang_seninjumat1']);
        if($check_pdsj1->count() == 0) {
            $presensi_datang_seninjumat1 = '06:00:00';
        } else {
            $presensi_datang_seninjumat1 = $check_pdsj1->first()->value;
        }

        $check_pdsj2 = DB::table('config')->where(['key' => 'presensi_datang_seninjumat2']);
        if($check_pdsj2->count() == 0) {
            $presensi_datang_seninjumat2 = '08:00:00';
        } else {
            $presensi_datang_seninjumat2 = $check_pdsj2->first()->value;
        }

        $check_ppsk1 = DB::table('config')->where(['key' => 'presensi_pulang_seninkamis1']);
        if($check_ppsk1->count() == 0) {
            $presensi_pulang_seninkamis1 = '15:00:00';
        } else {
            $presensi_pulang_seninkamis1 = $check_ppsk1->first()->value;
        }

        $check_ppsk2 = DB::table('config')->where(['key' => 'presensi_pulang_seninkamis2']);
        if($check_ppsk2->count() == 0) {
            $presensi_pulang_seninkamis2 = '17:00:00';
        } else {
            $presensi_pulang_seninkamis2 = $check_ppsk2->first()->value;
        }

        $check_ppj1 = DB::table('config')->where(['key' => 'presensi_pulang_jumat1']);
        if($check_ppj1->count() == 0) {
            $presensi_pulang_jumat1 = '10:45:00';
        } else {
            $presensi_pulang_jumat1 = $check_ppj1->first()->value;
        }

        $check_ppj2 = DB::table('config')->where(['key' => 'presensi_pulang_jumat2']);
        if($check_ppj2->count() == 0) {
            $presensi_pulang_jumat2 = '12:00:00';
        } else {
            $presensi_pulang_jumat2 = $check_ppj2->first()->value;
        }

        $check_latlong = DB::table('config')->where(['key' => 'location_latlong']);
        if($check_latlong->count() == 0) {
            $location_latlong = '-7.7646547,113.4185951';
        } else {
            $location_latlong = $check_latlong->first()->value;
        }

        $check_maxradius = DB::table('config')->where(['key' => 'max_radius']);
        if($check_maxradius->count() == 0) {
            $max_radius = '50';
        } else {
            $max_radius = $check_maxradius->first()->value;
        }

        // datang senin~jumat jam 06.00-08.00
        $timeDatangSeninJumat1 = Date('H:i:s', strtotime($presensi_datang_seninjumat1));
        $timeDatangSeninJumat2 = Date('H:i:s', strtotime($presensi_datang_seninjumat2));

        // pulang senin~kamis jam 15.00-17.00
        $timePulangSeninKamis1 = Date('H:i:s', strtotime($presensi_pulang_seninkamis1));
        $timePulangSeninKamis2 = Date('H:i:s', strtotime($presensi_pulang_seninkamis2));

        // pulang jumat 10.45-12.00
        $timePulangJumat1 = Date('H:i:s', strtotime($presensi_pulang_jumat1));
        $timePulangJumat2 = Date('H:i:s', strtotime($presensi_pulang_jumat2));

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

        $location = $validatedData['location'];
        $location = str_replace(' ', '', $location);

        $key = 'AIzaSyDavEi5c_uNC-45kkDP6Rc4VkZSWh5DVjI';
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$location.'&key='.$key;
        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        $maps = curl_exec($crl);
        curl_close($crl);
        
        if(is_object(json_decode($maps))) {
            $address = json_decode($maps)->results[0]->formatted_address;
            $address_lat = json_decode($maps)->results[0]->geometry->location->lat;
            $address_lng = json_decode($maps)->results[0]->geometry->location->lng;

            $location_latlong = str_replace(' ', '', $location_latlong);
            $o_explode = explode(',', $location_latlong);
            $lat = $o_explode[0];
            $long = $o_explode[1];
            // var_dump($lat);
            // var_dump($long);

            $location_distance = $this->get_distance_beetween($lat, $long, $address_lat, $address_lng);
            // var_dump($location_distance);

            if($location_distance > $max_radius) {
                return ResponseFormatter::error(
                    null,
                    'Lokasi presensi diluar area sekolah'
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                'Gagal mendapatkan lokasi presensi, silakan coba lagi'
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

    function get_distance_beetween($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'meters') {
        $theta = $longitude1 - $longitude2; 
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
        $distance = acos($distance); 
        $distance = rad2deg($distance); 
        $distance = $distance * 60 * 1.1515; 
        switch($unit) { 
            case 'miles': 
                break; 
            case 'kilometers': 
                $distance = $distance * 1.609344;
            case 'meters':
                $distance = $distance * 1.609344 * 1000;
        }
        return (round($distance, 2)); 
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
