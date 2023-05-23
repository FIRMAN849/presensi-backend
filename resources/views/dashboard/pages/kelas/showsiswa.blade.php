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
                        <th scope="col">Handle</th>
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
