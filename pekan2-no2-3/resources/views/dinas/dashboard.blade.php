@extends('layouts.dashboard')

@section('title', 'Dashboard Dinas | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Dinas</h1>
            <p class="page-subtitle">Selamat datang, {{ $user['name'] }} &bull; {{ $user['unit_kerja'] ?? 'Dinas Pendidikan' }}</p>
        </div>
        <a href="{{ route('dinas.pengajuan') }}" class="btn btn-primary">
            <i class="ri-inbox-line"></i> Pengajuan Masuk
            @if ($stats['pengajuan_baru'] > 0)
                <span class="badge-count">{{ $stats['pengajuan_baru'] }}</span>
            @endif
        </a>
    </div>

    <div class="grid grid-3" style="margin-bottom:2rem">
        @foreach ([
            ['icon' => 'ri-group-line', 'label' => 'Total ABK', 'value' => $stats['total_siswa'], 'color' => '#7c3aed', 'bg' => '#ede9fe'],
            ['icon' => 'ri-school-line', 'label' => 'Sekolah Terverifikasi', 'value' => $stats['total_sekolah'], 'color' => '#2563eb', 'bg' => '#dbeafe'],
            ['icon' => 'ri-building-line', 'label' => 'Mitra Aktif', 'value' => $stats['total_mitra'], 'color' => '#059669', 'bg' => '#d1fae5'],
            ['icon' => 'ri-inbox-line', 'label' => 'Pengajuan Baru', 'value' => $stats['pengajuan_baru'], 'color' => '#d97706', 'bg' => '#fef3c7'],
            ['icon' => 'ri-flow-chart', 'label' => 'Pipeline Proses', 'value' => $stats['pipeline_proses'], 'color' => '#0891b2', 'bg' => '#cffafe'],
            ['icon' => 'ri-check-double-line', 'label' => 'ABK Diterima', 'value' => $stats['pipeline_diterima'], 'color' => '#16a34a', 'bg' => '#dcfce7'],
        ] as $c)
            <div class="stat-card">
                <div class="stat-icon" style="background:{{ $c['bg'] }}">
                    <i class="{{ $c['icon'] }}" style="color:{{ $c['color'] }}"></i>
                </div>
                <div class="stat-value">{{ $c['value'] }}</div>
                <div class="stat-label">{{ $c['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div class="card-header"><h3>Aksi Cepat</h3></div>
            <div class="quick-actions">
                <a href="{{ route('dinas.siswa.index') }}" class="quick-action-btn"><i class="ri-group-line"></i><span>Database ABK</span></a>
                <a href="{{ route('dinas.pengajuan') }}" class="quick-action-btn"><i class="ri-inbox-line"></i><span>Pengajuan</span></a>
                <a href="{{ route('dinas.pipeline') }}" class="quick-action-btn"><i class="ri-flow-chart"></i><span>Pipeline</span></a>
                <a href="{{ route('dinas.mitra') }}" class="quick-action-btn"><i class="ri-building-line"></i><span>Kelola Mitra</span></a>
                <a href="{{ route('dinas.master') }}" class="quick-action-btn"><i class="ri-settings-3-line"></i><span>Master Data</span></a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Notifikasi Terbaru</h3>
                <button type="button" class="card-link" id="markAllRead">Tandai semua dibaca</button>
            </div>
            @if (count($notif) === 0)
                <p class="empty-state">Tidak ada notifikasi baru</p>
            @else
                <div class="notif-list" id="notifList">
                    @foreach ($notif as $n)
                        <div class="notif-item {{ empty($n['is_read']) ? 'unread' : '' }}">
                            <div class="notif-title">{{ $n['judul'] }}</div>
                            <div class="notif-pesan">{{ $n['pesan'] }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('markAllRead').addEventListener('click', function () {
        document.querySelectorAll('#notifList .notif-item').forEach(function (el) {
            el.classList.remove('unread');
        });
    });
});
</script>
@endpush
