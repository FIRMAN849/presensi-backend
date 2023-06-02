@extends('dashboard.layouts.main')

@section('container')
    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <form action="/izin/{{ $izin->id }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Nama</label>
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama"
                                value="{{ $izin->siswa->user->nama }}" disabled>
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
                                value="{{ $izin->tgl_izin }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Keterangan</label>
                            <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan" value="{{ $izin->keterangan }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Alasan</label>
                            <textarea class="form-control form-control-sm" id="alasan" name="alasan" disabled>{{ $izin->alasan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Status</label>
                            <select class="form-select" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Accept">Accept</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="my-3">
                            <img src="{{ asset('app/public/img/izin/' . $izin->image) }}" alt="" width="300px">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%">Edit</button>
                <a href="/izin" class="btn btn-danger mt-2" style="width: 100%">
                    Batal
                </a>
            </form>
        </div>
    </div>
@endsection
