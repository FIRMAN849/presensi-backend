<?php


namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller as ControllersController;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    // public function index()
    // {
    //     return 'test';
    // }

    public function create(Request $request)
    {
        // var_dump('create');
        // $izins = new Izin();

        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tgl_izin' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:1024',
            'keterangan' => 'required', // IZIN,SAKIT
            'alasan' => 'required'
        ]);

        $izins = new Izin();

        // dd($validatedData);


        $izins->fill($validatedData);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            // $request->image->move(public_path()::putFileAs('img/profile', $image, $filename));
            Storage::putFileAs('img/izin/', $image, $filename);
            $izins->image = '' . $filename;
        }
        $izins->status = 'Pending';


        $izins->save();

        return ResponseFormatter::success(
            $izins,
            'Berhasil Mengirim Izin'
        );



        // $izins->user_id = $request->nama;
        // $izins->kelas_id = $request->kelas;
        // $izins->tgl_izin = $request->tgl_izin;
        // $izins->image = $request->image;
        // $izins->keterangan = $request->image;
        // $izins->alasan = $request->alasan;
        // $result = $izins->save();

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

        if(strlen($siswa_id) == 0) {
            return ResponseFormatter::error(
                null,
                'ID Siswa tidak valid'
            );
        }

        $history_data = Izin::where('siswa_id', $siswa_id)->get();
        // dd($history_data);

        return ResponseFormatter::success(
            $history_data,
            'Berhasil mengambil riwayat izin'
        );
    }

    // public function store(Request $request)
    // {
    //     $attrs = $request->validate([
    //         'nama' => 'required',
    //         'kelas' => 'required',
    //         'tgl_izin' => 'required',
    //         'image' => 'required|file|max:1024',
    //         'alasan' => 'required'
    //     ]);

    //     $filename = "";
    //     if ($request->hasFile('image')) {
    //         $filename = $request->file('image')->store('izin-image');
    //     } else {
    //         $filename = Null;
    //     }

    //     $image = $this->saveImage($request->image, 'izin');

    //     $user = User::created([
    //         'nama' => $attrs['nama'],
    //         'kelas' => $attrs['kelas'],
    //         'tgl_izin' => $attrs['tgl_izin'],
    //         'image'
    //     ]);
    // }
}
