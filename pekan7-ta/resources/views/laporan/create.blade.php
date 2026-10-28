@extends('layouts.app')

@section('title', 'Form Laporan Banjir')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Form Laporan Banjir</div>
            <div class="card-body">
                {{-- enctype wajib ada agar file foto ikut terkirim --}}
                <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}"
                               class="form-control @error('nama_pelapor') is-invalid @enderror" required>
                        @error('nama_pelapor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                               class="form-control @error('no_hp') is-invalid @enderror" required>
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan"
                                    class="form-select @error('kecamatan') is-invalid @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach (\App\Models\Laporan::KECAMATAN as $kec)
                                    <option value="{{ $kec }}" @selected(old('kecamatan') == $kec)>{{ $kec }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tinggi_air" class="form-label">Tinggi Air (cm)</label>
                            <input type="number" id="tinggi_air" name="tinggi_air" value="{{ old('tinggi_air') }}" min="1"
                                   class="form-control @error('tinggi_air') is-invalid @enderror" required>
                            @error('tinggi_air') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi (desa / jalan / patokan)</label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                               class="form-control @error('lokasi') is-invalid @enderror" required>
                        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Kondisi Banjir (jpg, jpeg, png - maks. 2 MB)</label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                               class="form-control @error('foto') is-invalid @enderror" required>
                        @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
