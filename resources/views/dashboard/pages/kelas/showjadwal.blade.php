@extends('dashboard.layouts.main')

@section('container')
    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                        <th scope="col">Handle</th>
                        <th scope="col">Handle</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $jwl)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jwl->hari }}</td>
                            <td>{{ $jwl->mapel->nama_mapel }}</td>
                            <td>{{ $jwl->guru->nama_guru }}</td>
                            <td>{{ $jwl->kelas->nama_kelas }}</td>
                            <td>{{ \Carbon\Carbon::parse($jwl->jam_awal)->locale('id')->isoFormat('HH:mm') }}</td>
                            <td>{{ \Carbon\Carbon::parse($jwl->jam_akhir)->locale('id')->isoFormat('HH:mm') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
