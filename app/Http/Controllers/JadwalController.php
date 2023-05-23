<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.jadwal.index', [
            'title' => 'Jadwal',
            'active' => 'jadwal',
            'jadwal' => Jadwal::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.jadwal.create', [
            'title' => 'Tambah Jadwal',
            'active' => 'jadwal',
            'jadwal' => Jadwal::all(),
            'mapel' => Mapel::all(),
            'guru' => Guru::all(),
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

        $validedData = $request->validate([
            'hari' => 'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'guru_id' => 'required',
            'jam_awal' => 'required ',
            'jam_akhir' => 'required',
        ]);

        // $validedData['jam_awal'] = Carbon::format('H:i');
        // $validedData['jam_akhir'] = Carbon::format('H:i');

        Jadwal::create($validedData);

        // $jadwal = Carbon::createFromFormat('H:i', $request->jam_awal)->format('H:i');
        // $jadwal = new Jadwal([
        //     'hari' => $request->input('hari'),
        //     'mapel_id' => $request->input('mapel'),
        //     'guru_id' => $request->input('guru'),
        //     'kelas_id' => $request->input('kelas'),
        //     'jam_awal' => $request->input('jam_awal'),
        //     'jam_akhir' => $request->input('jam_akhir')
        // ]);
        // $jadwal->save();



        return redirect('/jadwal')->with('success', 'Berhasil menambahkan jadwal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
