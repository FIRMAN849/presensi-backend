<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.siswa.index', [
            'title' => 'Data Siswa',
            'active' => 'datasiswa',
            'users' => User::all(),
            'students' => Siswa::all(),
            'categories' => Kelas::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.siswa.create', [
            'title' => 'Tambah Siswa',
            'active' => 'datasiswa',
            'users' => User::all(),
            'students' => Siswa::all(),
            'categories' => Kelas::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'nama' => 'required',
        //     'username' => 'required|unique:users,username',
        //     // 'nis' => 'required|unique:users,nis',
        //     // 'kelas' => 'required',
        //     // 'tgl_lahir' => 'required',
        //     // 'alamat' => 'required',
        //     // 'jenis_kelamin' => 'required',
        //     // 'email' => 'required|unique:users,email',
        //     'role' => 'required',
        //     'password' => 'required|min:5|max:255'
        // ]);
        // dd($request);
        $request->validate([
            'nama' => 'required|string',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:5',
            'nis' => 'required|unique:siswas,nis',
            'kelas' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:siswas,email',
        ]);


        $user = new User([
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'role' => 'user',
            'image' => 'default.png',
            'password' => bcrypt($request->input('password'))
        ]);
        $user->save();

        $siswa = new Siswa([
            'user_id' => $user->id,
            'nis' => $request->input('nis'),
            'kelas_id' => $request->input('kelas'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'alamat' => $request->input('alamat'),
            'email' => $request->input('email')
        ]);
        $siswa->save();
        return redirect('/siswa')->with('success', 'Berhasil menambahkan user');
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
    public function edit(Siswa $siswa)
    {
        return view('dashboard.pages.siswa.edit', [
            'title' => 'Edit Siswa',
            'active' => 'datasiswa',
            'users' => User::all(),
            'students' => $siswa,
            'categories' => Kelas::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string',
            'username' => 'required|unique:users,username,' . $siswa->user_id,
            'password' => 'required|min:5',
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'kelas' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:siswas,email,' . $siswa->id,
        ]);

        $user = User::find($siswa->user_id);

        $user->update([
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password'))
        ]);

        $siswa->update([
            'nis' => $request->input('nis'),
            'kelas_id' => $request->input('kelas'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'alamat' => $request->input('alamat'),
            'email' => $request->input('email')
        ]);
        return redirect('/siswa')->with('success', 'Berhasil mengubah user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        $user = User::find($siswa->user_id);
        $user->delete();
        return redirect('/siswa')->with('success', 'Berhasil Hapus siswa');
    }
}
