@extends('layouts.app')

@section('title', 'Konfirmasi Laporan')

@section('content')
<div class="card">
    <div class="alert">Laporan berhasil dikirim. Terima kasih!</div>

    <table class="detail">
        <tr>
            <th>Nama Pelapor</th>
            <td>{{ $laporan['nama_pelapor'] }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>Desa {{ $laporan['desa'] }}, Kec. {{ $laporan['kecamatan'] }}</td>
        </tr>
        <tr>
            <th>Tinggi Genangan</th>
            <td>{{ $laporan['tinggi_genangan'] }} cm</td>
        </tr>
        <tr>
            <th>Status</th>
            <td><span class="badge badge-{{ strtolower($status) }}">{{ $status }}</span></td>
        </tr>
    </table>

    <a href="{{ route('laporan-banjir.create') }}" class="btn">Buat Laporan Baru</a>
</div>
@endsection