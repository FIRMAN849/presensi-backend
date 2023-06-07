@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="mb-2">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="card mb-5" style="border-radius: 15px">
        <div class="card-body">
            <table id="table_siswa" class="display">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Image</th>
                        <th>Keterangan</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($izin as $i)
                        <tr>
                            <td valign="top">{{ $loop->iteration }}</td>
                            <td valign="top">{{ $i->siswa->user->nama }}</td>
                            <td valign="top">{{ $i->kelas->nama_kelas }}</td>
                            <td valign="top">{{ $i->tgl_izin }}</td>
                            <td valign="top">
                                <img src="{{ asset('app/public/img/izin/' . $i->image) }}" width="180px" />
                            </td>
                            <td valign="top">{{ $i->keterangan }}</td>
                            <td valign="top">{{ $i->alasan }}</td>
                            <td valign="top">
                                @if ($i->status == 'Pending')
                                    <span class="badge bg-warning">{{ $i->status }}</span>
                                @elseif ($i->status == 'Ditolak')
                                    <span class="badge bg-danger">{{ $i->status }}</span>
                                @else
                                    <span class="badge bg-success">{{ $i->status }}</span>
                                @endif
                            </td>
                            <td valign="top">
                                <a href="/izin/{{ $i->id }}/edit" class="btn btn-primary btn-sm">
                                    <i class='bx bx-menu'></i>
                                </a>
                                {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class='bx bx-menu'></i>
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>




    {{--
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/izin/{{ $i->id }}/" method="post">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label class="col-form-label-sm">Nama</label>
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama"
                                value="{{ $i->user->nama }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Kelas</label>
                            <select class="form-select" name="kelas" disabled>
                                @foreach ($categories as $kelas)
                                    @if (old('kelas') === $kelas->id)
                                        <option value="{{ $kelas->id }}" selected>{{ $kelas->nama_kelas }}</option>
                                    @else
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Tanggal Izin</label>
                            <input type="date" class="form-control form-control-sm" id="tgl_izin" name="tgl_izin"
                                value="{{ $i->tgl_izin }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Keterangan</label>
                            <textarea class="form-control form-control-sm" id="keterangan" name="keterangan" disabled>{{ $i->keterangan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Status</label>
                            <select class="form-select" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Accept">Accept</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div> --}}





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_siswa').DataTable({
                ordering: false,
                responsive: true
            });
        });

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
