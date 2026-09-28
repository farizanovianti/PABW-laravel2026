@extends('layouts.dashboard')

@section('title', 'Database ABK | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Database ABK</h1>
            <p class="page-subtitle">{{ count($siswa) }} siswa terdaftar</p>
        </div>
    </div>

    <div class="card">
        <div class="card-toolbar" style="display:flex;gap:0.75rem;flex-wrap:wrap">
            <div class="search-box" style="flex:1;min-width:200px">
                <i class="ri-search-line"></i>
                <input type="text" id="searchNama" placeholder="Cari nama siswa...">
            </div>
            <select class="form-control" id="filterKota" style="width:auto">
                <option value="">Semua Kota</option>
                @foreach ($kotaList as $k)
                    <option value="{{ $k }}">{{ $k }}</option>
                @endforeach
            </select>
            <input class="form-control" id="filterDis" style="width:180px" placeholder="Filter disabilitas...">
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Disabilitas</th>
                        <th>Sekolah</th>
                        <th>Kota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $s)
                        <tr class="abk-row"
                            data-nama="{{ strtolower($s['nama_lengkap']) }}"
                            data-kota="{{ $s['kota_kabupaten'] }}"
                            data-dis="{{ strtolower($s['kategori_disabilitas']) }}">
                            <td>
                                <div style="display:flex;align-items:center;gap:0.5rem">
                                    <div class="avatar-sm">{{ mb_substr($s['nama_lengkap'], 0, 1) }}</div>
                                    {{ $s['nama_lengkap'] }}
                                </div>
                            </td>
                            <td>{{ $s['kelas'] }}</td>
                            <td><span class="badge badge-info">{{ $s['kategori_disabilitas'] ?: '-' }}</span></td>
                            <td>{{ $s['nama_sekolah'] }}</td>
                            <td>{{ $s['kota_kabupaten'] }}</td>
                            <td>
                                <span class="badge badge-{{ $s['status'] === 'aktif' ? 'success' : 'warning' }}">{{ $s['status'] }}</span>
                            </td>
                            <td>
                                <a href="{{ route('dinas.siswa.show', $s['id_siswa']) }}" class="btn btn-sm btn-outline">
                                    <i class="ri-eye-line"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-light)">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function applyFilter() {
        var q = document.getElementById('searchNama').value.toLowerCase();
        var kota = document.getElementById('filterKota').value;
        var dis = document.getElementById('filterDis').value.toLowerCase();
        var visible = 0;

        document.querySelectorAll('.abk-row').forEach(function (row) {
            var match = row.dataset.nama.indexOf(q) !== -1
                && (!kota || row.dataset.kota === kota)
                && (!dis || row.dataset.dis.indexOf(dis) !== -1);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        var empty = document.getElementById('abkEmpty');
        if (empty) empty.style.display = visible === 0 ? '' : 'none';
    }

    ['searchNama', 'filterKota', 'filterDis'].forEach(function (id) {
        document.getElementById(id).addEventListener('input', applyFilter);
        document.getElementById(id).addEventListener('change', applyFilter);
    });
});
</script>
@endpush
