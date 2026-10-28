@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Laporan Banjir</h2>
    <a href="{{ route('laporan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Laporan
    </a>
</div>

<div class="table-responsive">
<table class="table table-bordered align-middle bg-white">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Pelapor</th>
            <th>Lokasi</th>
            <th>Tinggi Air</th>
            <th>Status</th>
            <th>Dilaporkan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($laporans as $laporan)
            <tr>
                <td>{{ $laporans->firstItem() + $loop->index }}</td>
                <td>
                    @if ($laporan->foto)
                        <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto {{ $laporan->lokasi }}"
                             width="60" height="60" class="rounded object-fit-cover">
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
                <td>{{ $laporan->nama_pelapor }}<br><small class="text-muted">{{ $laporan->no_hp }}</small></td>
                <td>{{ $laporan->lokasi }}<br><small class="text-muted">Kec. {{ $laporan->kecamatan }}</small></td>
                <td>{{ $laporan->tinggi_air }} cm</td>
                <td>
                    @if ($laporan->status == 'Selesai')
                        <span class="badge bg-success">Selesai</span>
                    @elseif ($laporan->status == 'Diproses')
                        <span class="badge bg-warning text-dark">Diproses</span>
                    @else
                        <span class="badge bg-secondary">Menunggu</span>
                    @endif
                </td>
                <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('laporan.show', $laporan) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('laporan.edit', $laporan) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('laporan.destroy', $laporan) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada laporan banjir.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{ $laporans->links() }}
@endsection
