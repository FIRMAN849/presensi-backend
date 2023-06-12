@extends('dashboard.layouts.main')

@section('container')
    <div class="card" style="border-radius: 15px">
        <div class="card-body">
            <form action="/jadwal/ {{ $jadwal->id }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Hari</label>
                            <select class="form-select" name="hari">
                                <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                                <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                <option value="Jum'at" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jum'at</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Mapel</label>
                            <select class="form-select" name="mapel_id">
                                @foreach ($mapel as $m)
                                    @if (old('mapel_id', $jadwal->mapel_id) === $m->id)
                                        <option value="{{ $m->id }}" selected>
                                            {{ $m->nama_mapel }}
                                        </option>
                                    @else
                                        <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Jam Awal</label>
                            <input type="time"
                                class="form-control form-control-sm @error('jam_awal') is-invalid @enderror" id="jam_awal"
                                name="jam_awal" value="{{ $jadwal->jam_awal }}">
                            @error('jam_awal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label-sm">Kelas</label>
                            <select class="form-select" name="kelas_id">
                                @foreach ($categories as $kelas)
                                    @if (old('kelas_id', $jadwal->kelas_id) === $kelas->id)
                                        <option value="{{ $kelas->id }}" selected>{{ $kelas->nama_kelas }}</option>
                                    @else
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Guru</label>
                            <select class="form-select" name="guru_id">
                                @foreach ($guru as $g)
                                    @if (old('guru_id', $jadwal->guru_id) === $g->id)
                                        <option value="{{ $g->id }}" selected>{{ $g->nama_guru }}</option>
                                    @else
                                        <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label-sm">Jam Akhir</label>
                            <input type="time"
                                class="form-control form-control-sm @error('jam_akhir') is-invalid @enderror" id="jam_akhir"
                                name="jam_akhir" value="{{ $jadwal->jam_akhir }}">
                            @error('jam_akhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%">EDIT</button>
                <a href="/jadwal" class="btn btn-danger mt-2" style="width: 100%">
                    Batal
                </a>
            </form>
        </div>
    </div>
@endsection
