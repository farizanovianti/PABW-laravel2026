@extends('layouts.dashboard')

@php($levelColor = ['belum' => '#94a3b8', 'dasar' => '#3b82f6', 'mahir' => '#f59e0b', 'ahli' => '#10b981'])
@php($tahapColor = ['direkomendasikan' => '#3b82f6', 'wawancara' => '#f59e0b', 'penawaran' => '#8b5cf6', 'diterima' => '#10b981', 'ditolak' => '#ef4444'])

@section('title', 'Profil ABK | InkluSkill')

@section('content')
<div>
    <button type="button" class="btn btn-outline btn-sm" onclick="history.back()" style="margin-bottom:1rem">
        <i class="ri-arrow-left-line"></i> Kembali
    </button>

    <div class="card profil-header" style="margin-bottom:1.5rem">
        <div class="profil-avatar">{{ mb_substr($siswa['nama_lengkap'], 0, 1) }}</div>
        <div class="profil-info">
            <h2>{{ $siswa['nama_lengkap'] }}</h2>
            <p style="color:var(--text-light)">
                {{ $siswa['kategori_disabilitas'] }} &bull; {{ $siswa['kelas'] }} &bull; {{ $siswa['nama_sekolah'] }}
            </p>
            <p style="color:var(--text-light);font-size:0.85rem">{{ $siswa['kota_kabupaten'] }}</p>
        </div>
        <div>
            <span class="badge badge-{{ $siswa['status'] === 'aktif' ? 'success' : 'warning' }}">{{ $siswa['status'] }}</span>
        </div>
    </div>

    <div class="tabs" style="margin-bottom:1.5rem">
        <button type="button" class="tab-btn active" data-tab="log">Log Aktivitas</button>
        <button type="button" class="tab-btn" data-tab="kompetensi">Kompetensi</button>
        <button type="button" class="tab-btn" data-tab="pengajuan">Pengajuan</button>
        <button type="button" class="tab-btn" data-tab="pipeline">Pipeline</button>
    </div>

    <div class="card tab-panel" data-panel="log">
        @if (count($log_aktivitas) === 0)
            <p class="empty-state">Belum ada log</p>
        @else
            <div class="log-list">
                @foreach ($log_aktivitas as $l)
                    <div class="log-item">
                        <div class="log-date">{{ $l['tanggal_sesi'] }}</div>
                        <div class="log-content">
                            <span style="font-weight:500">{{ $l['nama_keterampilan'] }}</span>
                            <span class="badge" style="background:{{ $levelColor[$l['level_tercapai']] }};color:white;margin-left:0.5rem">{{ $l['level_tercapai'] }}</span>
                            <span class="badge badge-{{ $l['status_validasi'] === 'tervalidasi' ? 'success' : 'warning' }}" style="margin-left:0.25rem">{{ $l['status_validasi'] }}</span>
                            <div style="font-size:0.85rem;color:var(--text-light);margin-top:0.25rem">Oleh: {{ $l['nama_guru'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card tab-panel" data-panel="kompetensi" style="display:none">
        @if (count($kompetensi_tervalidasi) === 0)
            <p class="empty-state">Belum ada kompetensi tervalidasi</p>
        @else
            <div class="grid grid-2">
                @foreach ($kompetensi_tervalidasi as $v)
                    <div class="kompetensi-card">
                        <div style="display:flex;justify-content:space-between">
                            <span style="font-weight:600">{{ $v['nama_keterampilan'] }}</span>
                            <span class="badge" style="background:{{ $levelColor[$v['level_tercapai']] }};color:white">{{ $v['level_tercapai'] }}</span>
                        </div>
                        <div style="font-size:0.8rem;color:var(--text-light);margin-top:0.25rem">
                            {{ explode(' ', $v['tanggal_validasi'])[0] }} &bull; {{ $v['nama_validator'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card tab-panel" data-panel="pengajuan" style="display:none">
        @if (count($pengajuan) === 0)
            <p class="empty-state">Belum ada pengajuan</p>
        @else
            <div class="table-wrapper">
                <table class="data-table">
                    <thead><tr><th>Tanggal</th><th>Guru</th><th>Keterangan</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach ($pengajuan as $p)
                            <tr>
                                <td>{{ explode(' ', $p['tanggal_pengajuan'])[0] }}</td>
                                <td>{{ $p['nama_guru'] }}</td>
                                <td>{{ $p['keterangan'] ?: '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $p['status'] === 'diterima' ? 'success' : ($p['status'] === 'dikembalikan' ? 'danger' : 'warning') }}">
                                        {{ $p['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card tab-panel" data-panel="pipeline" style="display:none">
        @if (count($pipeline) === 0)
            <p class="empty-state">Belum ada pipeline</p>
        @else
            @foreach ($pipeline as $p)
                <div class="pipeline-item" style="display:flex;justify-content:space-between;padding:0.75rem;border-bottom:1px solid var(--border)">
                    <div>
                        <div style="font-weight:500">{{ $p['nama_perusahaan'] ?: 'Tanpa perusahaan' }}</div>
                        @if ($p['judul_posisi'])
                            <div style="font-size:0.85rem;color:var(--text-light)">{{ $p['judul_posisi'] }}</div>
                        @endif
                    </div>
                    <span class="badge" style="background:{{ $tahapColor[$p['status_tahap']] }};color:white">{{ $p['status_tahap'] }}</span>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
            document.querySelectorAll('.tab-panel').forEach(function (p) { p.style.display = 'none'; });
            btn.classList.add('active');
            document.querySelector('.tab-panel[data-panel="' + btn.dataset.tab + '"]').style.display = '';
        });
    });
});
</script>
@endpush
