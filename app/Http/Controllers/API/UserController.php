<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use APP\Http\Controllers\API\Controller;
use App\Http\Controllers\Controller as ControllersController;
use App\Models\User;
use App\Models\Siswa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Validator;


class UserController extends ControllersController
{

    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $credentials = request(['username', 'password']);

            if ($request->password == '') {
                return ResponseFormatter::error(null, 'Authentication Failed', 500);
            }

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error(null, 'Username / Password Salah', 500);
            }

            $user = User::where('username', $request->username)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $user['access_token'] = $tokenResult;
            $user['token_type'] = 'Bearer';
            return ResponseFormatter::success(
                $user,
                'Aunthenticated'
            );
        } catch (Exception $e) {
        }
    }

    public function fetch(Request $request)
    {
        // $user = Auth::user();

        // $siswa = Siswa::where('user_id', $user->id)->first();
        // $siswa = Siswa::with('kelas')
        //     ->where('user_id', $user->id)
        //     ->get();

        // $siswa_list = [];
        // foreach ($siswa as $s) {
        //     $siswa_dict = [
        //         'id' => $s->id,
        //         'user_id' => $s->user_id,
        //         'nis' => $s->nis,
        //         'kelas_id' => $s->kelas->nama_kelas,
        //         'tgl_lahir' => $s->tgl_lahir,
        //         'alamat' => $s->alamat,
        //         'jenis_kelamin' => $s->jenis_kelamin,
        //         'email' => $s->email,
        //     ];
        //     $siswa_list[] = $siswa_dict;
        // }

        // // return ResponseFormatter::success(
        // //     $siswa,
        // //     'Data Siswa Berhasil Diambil'
        // // );

        // return ResponseFormatter::success(
        //     $request->user(),
        //     $siswa_list,

        //     'Data Profile user berhasil diambil'
        // );
        // return response()->json(['siswa' => $siswa]);

        $user = $request->user();
        // $user->image = env('APP_URL') . 'img/profile/' . $user->image;

        // $siswas = DB::table('siswas')
        //     ->join('users', 'siswas.user_id', '=', 'users.id')
        //     ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
        //     ->where('siswas.user_id', $user->id)
        //     ->get();

        $siswas = Siswa::with(['user', 'kelas'])->whereHas('user', function ($q) use ($user) {
            $q->where('id', $user->id);
        })->first();
        // $siswas = Siswa::with('kelas');
        // $siswas->map(function ($siswa) {
        //     $siswa->user->image = env('APP_URL') . 'img/profile/' . $siswa->user->image;
        // });

        $siswas->user->image = env('APP_URL') . 'app/public/img/profile/' . $siswas->user->image;

        // $book->cover = env('APP_URL') . '/app/books/' . $book->cover;


        return ResponseFormatter::success(
            $siswas,
            'Data Profile user berhasil diambil'
        );
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($user->siswa) {
            $user->siswa->alamat = $request->input('alamat');
            $user->siswa->tgl_lahir = $request->input('tgl_lahir');
            $user->siswa->email = $request->input('email');

            $user->siswa->save();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            // $request->image->move(public_path()::putFileAs('img/profile', $image, $filename));
            Storage::putFileAs('img/profile/', $image, $filename);
            $user->image = '' . $filename;
        }

        $user->save();
        $user->siswa->save();

        return ResponseFormatter::success(
            'Data Berhasil diubah'
        );
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function updatepassword(Request $request, $id)
    {

        $user = User::find($id);

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|different:current_password|min:5'
        ]);

        // $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return ResponseFormatter::error(null, 'Kata sandi saat ini tidak cocok', 500);
        }

        // $user->password = Hash::make($request->new_password);
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // $user->save();

        return ResponseFormatter::success(
            null,
            'Data Berhasil diubah'
        );
    }
}
