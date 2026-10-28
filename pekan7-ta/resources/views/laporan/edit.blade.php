@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Edit Laporan #{{ $laporan->id }}</div>
            <div class="card-body">
                <form action="{{ route('laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Penanganan</label>
                        <select id="status" name="status"
                                class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (\App\Models\Laporan::STATUS as $status)
                                <option value="{{ $status }}" @selected(old('status', $laporan->status) == $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor', $laporan->nama_pelapor) }}"
                               class="form-control @error('nama_pelapor') is-invalid @enderror" required>
                        @error('nama_pelapor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $laporan->no_hp) }}"
                               class="form-control @error('no_hp') is-invalid @enderror" required>
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan"
                                    class="form-select @error('kecamatan') is-invalid @enderror" required>
                                @foreach (\App\Models\Laporan::KECAMATAN as $kec)
                                    <option value="{{ $kec }}" @selected(old('kecamatan', $laporan->kecamatan) == $kec)>{{ $kec }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tinggi_air" class="form-label">Tinggi Air (cm)</label>
                            <input type="number" id="tinggi_air" name="tinggi_air" value="{{ old('tinggi_air', $laporan->tinggi_air) }}" min="1"
                                   class="form-control @error('tinggi_air') is-invalid @enderror" required>
                            @error('tinggi_air') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi (desa / jalan / patokan)</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $laporan->lokasi) }}"
                               class="form-control @error('lokasi') is-invalid @enderror" required>
                        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $laporan->keterangan) }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Foto Saat Ini</label>
                        @if ($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto {{ $laporan->lokasi }}"
                                 width="160" class="rounded mb-2">
                        @else
                            <p class="text-muted">Belum ada foto.</p>
                        @endif
                        <input type="file" id="foto" name="foto" accept="image/*"
                               class="form-control @error('foto') is-invalid @enderror">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
