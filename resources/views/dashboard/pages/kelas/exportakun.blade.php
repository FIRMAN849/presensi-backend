<html>

<head>
    <title>Cetak Akun</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            width: 21cm;
        }

        .separator {
            padding-top: 15px;
        }

        .static {
            position: relative;
            border: 1px solid #000000;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="separator"></div>
    <p><b>Akun {{ $nama_kelas }}</b></p>
    <table class="static" align="center" border="1px" style="width: 95%">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Kelas</th>
                <th scope="col">Username</th>
                <th scope="col">Passord</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->user->nama }}</td>
                    <td>{{ $s->kelas->nama_kelas }}</td>
                    <td>{{ $s->user->username }}</td>
                    <td>{{ $s->user->username }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
