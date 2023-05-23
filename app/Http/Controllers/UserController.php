<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.user.index', [
            'title' => 'Data User',
            'active' => 'datauser',
            'users' => User::all(),
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
        return view('dashboard.pages.user.create', [
            'title' => 'Tambah User',
            'active' => 'datauser',
            'users' => User::all(),
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

        // dd($request);
        //return request()->all();

        $validatedData = $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            // 'nis' => 'required|unique:users,nis',
            // 'kelas' => 'required',
            // 'tgl_lahir' => 'required',
            // 'alamat' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'email' => 'required|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:5|max:255'
        ]);



        // $validatedData['id'] = auth()->user()->id;
        $validatedData['password'] = Hash::make($validatedData['password']);

        // dd($validatedData);
        User::create($validatedData);


        return redirect('/user')->with('success', 'Berhasil menambahkan user');
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
    public function edit(User $user)
    {
        return view('dashboard.pages.user.edit', [
            'title' => 'Edit User',
            'active' => 'datauser',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'nama' => 'required',
            'role' => 'required',
            'password' => 'required|min:5|max:255'
        ];

        if ($request->username != $user->username) {
            $rules['username'] = 'required|unique:users,username';
        }

        $validatedData = $request->validate($rules);

        // $validatedData['id'] = auth()->user()->id;
        $validatedData['password'] = Hash::make($validatedData['password']);

        // dd($validatedData);
        User::where('id', $user->id)
            ->update($validatedData);

        return redirect('/user')->with('success', 'Berhasil mengupdate user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/user')->with('success', 'Berhasil menghapus user');
    }
}
