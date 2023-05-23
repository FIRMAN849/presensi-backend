<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.kelas.index', [
            'title' => 'Kelas',
            'active' => 'kelas',
            'kelas' => Kelas::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.kelas.create', [
            'title' => 'Tambah Kelas',
            'active' => 'kelas',
            'kelas' => Kelas::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKelasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKelasRequest $request)
    {
        $data = $request->all();

        Kelas::create($data);
        // $validedData = $request->validate([
        //     'nama_kelas' => 'required'
        // ]);

        // Kelas::create($validedData);

        return redirect('/kelas')->with('success', 'Berhasil menambahkan kelas');
    }

    public function siswa($id)
    {
        // return Siswa::find($id);

        $nama = 'asc';
        $siswa = Siswa::join('users', 'siswas.user_id', '=', 'users.id')
            ->where('siswas.kelas_id', $id)
            ->orderBy('users.nama', $nama)
            ->get();

        // $siswa = DB::table('siswas')
        //     ->join('users', 'siswas.kelas_id', '=', 'users.id')
        //     ->where('siswas.kelas_id', $id)
        //     ->orderBy('users.nama')
        //     ->get();



        return view('dashboard.pages.kelas.showsiswa', [
            'title' => 'Siswa',
            'active' => 'kelas',
            'students' => $siswa
        ]);
    }
    public function jadwal($id)
    {
        //  return Jadwal::find($id);
        $jadwalKelas = Jadwal::where('kelas_id', $id)
            ->orderBy('hari', 'desc')
            ->orderBy('jam_awal')
            ->get();

        return view('dashboard.pages.kelas.showjadwal', [
            'title' => 'Jadwal Kelas',
            'active' => 'kelas',
            'jadwal' => $jadwalKelas
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas, $id)
    {
        // return Jadwal::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKelasRequest  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        //
    }
}
