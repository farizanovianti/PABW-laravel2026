@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Detail Laporan #{{ $laporan->id }}</div>
            <div class="card-body">
                @if ($laporan->foto)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto {{ $laporan->lokasi }}"
                             class="img-fluid rounded mb-3" style="max-height: 320px">
                    </div>
                @endif

                <table class="table table-sm">
                    <tr><th width="35%">Nama Pelapor</th><td>{{ $laporan->nama_pelapor }}</td></tr>
                    <tr><th>No HP</th><td>{{ $laporan->no_hp }}</td></tr>
                    <tr><th>Lokasi</th><td>{{ $laporan->lokasi }}, Kec. {{ $laporan->kecamatan }}</td></tr>
                    <tr>
                        <th>Tinggi Air</th>
                        <td>
                            {{ $laporan->tinggi_air }} cm
                            @if ($laporan->tinggi_air < 30)
                                <span class="badge bg-info text-dark">Waspada</span>
                            @elseif ($laporan->tinggi_air <= 70)
                                <span class="badge bg-warning text-dark">Siaga</span>
                            @else
                                <span class="badge bg-danger">Awas</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Keterangan</th><td>{{ $laporan->keterangan ?? '-' }}</td></tr>
                    <tr><th>Status Penanganan</th><td>{{ $laporan->status }}</td></tr>
                    <tr><th>Dilaporkan</th><td>{{ $laporan->created_at->format('d-m-Y H:i') }} ({{ $laporan->created_at->diffForHumans() }})</td></tr>
                </table>

                <a href="{{ route('laporan.edit', $laporan) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('laporan.destroy', $laporan) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                </form>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
