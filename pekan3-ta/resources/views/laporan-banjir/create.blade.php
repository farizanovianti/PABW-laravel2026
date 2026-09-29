@extends('layouts.app')

@section('title', 'Form Laporan')

@section('content')
<div class="card">
    <h2>Form Laporan Banjir</h2>

    <form action="{{ route('laporan-banjir.store') }}" method="POST">
        @csrf
        <x-input name="nama_pelapor" label="Nama Pelapor" placeholder="Nama lengkap" />
        <x-input name="kecamatan" label="Kecamatan" placeholder="cth. Baleendah" />
        <x-input name="desa" label="Desa" placeholder="cth. Andir" />
        <x-input name="tinggi_genangan" label="Tinggi Genangan (cm)" type="number" min="1" />

        <button type="submit" class="btn">Kirim Laporan</button>
    </form>
</div>
@endsection