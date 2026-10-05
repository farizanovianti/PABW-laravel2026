@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<div class="card">
    <h2>Daftar Laporan Banjir</h2>

    @forelse ($daftarLaporan as $laporan)
        @if ($laporan->tinggi_genangan < 30)
            @php($status = 'Waspada')
        @elseif ($laporan->tinggi_genangan <= 70)
            @php($status = 'Siaga')
        @else
            @php($status = 'Awas')
        @endif

        @include('partials.laporan-card', ['laporan' => $laporan, 'status' => $status])
    @empty
        <p class="empty">Belum ada laporan banjir.</p>
    @endforelse
</div>
@endsection

