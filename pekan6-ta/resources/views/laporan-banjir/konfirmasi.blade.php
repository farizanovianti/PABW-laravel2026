@extends('layouts.app')

@section('title', 'Konfirmasi Laporan')

@section('content')
<div class="card">
    <x-alert type="success">
        Laporan berhasil dikirim dan tersimpan. Terima kasih, {{ $laporan->nama_pelapor }}!
    </x-alert>

    <h2>Data Laporan Anda</h2>
    @include('partials.laporan-card', ['laporan' => $laporan])

    <a href="{{ route('laporan-banjir.create') }}" class="btn">Buat Laporan Baru</a><br>
    <a href="{{ route('laporan-banjir.index') }}" class="btn">Lihat Daftar Laporan</a>
</div>
@endsection

