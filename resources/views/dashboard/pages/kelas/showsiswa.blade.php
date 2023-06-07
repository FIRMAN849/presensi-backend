@extends('dashboard.layouts.main')

@section('container')
    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nisn</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">tanggal Lahir</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $s->user->nama }}</td>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->kelas->nama_kelas }}</td>
                            <td>{{ $s->tgl_lahir }}</td>
                            <td>{{ $s->jenis_kelamin }}</td>
                            <td>{{ $s->alamat }}</td>
                            <td>{{ $s->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
