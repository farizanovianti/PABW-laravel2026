@extends('layouts.dashboard')

@section('title', 'Dashboard Guru | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Selamat datang, {{ $user['name'] }}</h1>
            <p class="page-subtitle">Ringkasan aktivitas kelas hari ini</p>
        </div>
        <a href="{{ route('guru.pengajuan') }}" class="btn btn-primary">
            <i class="ri-send-plane-line"></i> Ajukan ke Dinas
        </a>
    </div>

    <div class="grid grid-4" style="margin-bottom:2rem">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe"><i class="ri-group-line" style="color:#7c3aed"></i></div>
            <div class="stat-value">{{ $stats['total_siswa'] }}</div>
            <div class="stat-label">Total Siswa</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe"><i class="ri-calendar-check-line" style="color:#2563eb"></i></div>
            <div class="stat-value">{{ $stats['total_sesi'] }}</div>
            <div class="stat-label">Sesi Latihan</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7"><i class="ri-time-line" style="color:#d97706"></i></div>
            <div class="stat-value">{{ $stats['menunggu_validasi'] }}</div>
            <div class="stat-label">Menunggu Validasi</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5"><i class="ri-send-plane-line" style="color:#059669"></i></div>
            <div class="stat-value">{{ $stats['total_pengajuan'] }}</div>
            <div class="stat-label">Pengajuan ke Dinas</div>
        </div>
    </div>

    <div class="card" style="margin-bottom:1.5rem">
        <div class="card-header">
            <h3>Daftar Siswa Saya</h3>
            <a href="{{ route('guru.siswa.index') }}" class="card-link">Lihat semua</a>
        </div>

        @if (count($siswa) === 0)
            <div class="empty-state">
                <i class="ri-group-line" style="font-size:2.5rem;color:var(--extra-light)"></i>
                <p>Belum ada siswa terdaftar</p>
            </div>
        @else
            <div class="guru-siswa-grid">
                @foreach (array_slice($siswa, 0, 6) as $s)
                    <div class="guru-siswa-card">
                        <div class="guru-siswa-top">
                            <div class="guru-siswa-avatar">{{ mb_substr($s['nama_lengkap'], 0, 1) }}</div>
                            <div class="guru-siswa-info">
                                <div class="guru-siswa-nama">{{ $s['nama_lengkap'] }}</div>
                                <div class="guru-siswa-meta">{{ $s['kategori_disabilitas'] ?: 'ABK' }}</div>
                                <div class="guru-siswa-meta">{{ $s['kelas'] }}</div>
                            </div>
                            <span class="badge badge-{{ $s['status'] === 'aktif' ? 'success' : 'warning' }}">
                                {{ $s['status'] }}
                            </span>
                        </div>
                        <div class="guru-siswa-actions">
                            <a href="{{ route('guru.siswa.show', $s['id_siswa']) }}" class="guru-action-btn primary">
                                <i class="ri-eye-line"></i> Detail
                            </a>
                            <a href="{{ route('guru.validasi') }}" class="guru-action-btn warning">
                                <i class="ri-shield-check-line"></i> Validasi
                            </a>
                            <a href="{{ route('guru.pengajuan') }}" class="guru-action-btn success">
                                <i class="ri-send-plane-line"></i> Ajukan
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div class="card-header"><h3>Aksi Cepat</h3></div>
            <div class="quick-actions">
                <a href="{{ route('guru.siswa.index') }}" class="quick-action-btn"><i class="ri-group-line"></i><span>Daftar Siswa</span></a>
                <a href="{{ route('guru.validasi') }}" class="quick-action-btn"><i class="ri-shield-check-line"></i><span>Validasi Log</span></a>
                <a href="{{ route('guru.siswa.index') }}" class="quick-action-btn"><i class="ri-fire-line"></i><span>Skill Siswa</span></a>
                <a href="{{ route('guru.modul') }}" class="quick-action-btn"><i class="ri-book-open-line"></i><span>Modul Ajar</span></a>
                <a href="{{ route('guru.pengajuan') }}" class="quick-action-btn"><i class="ri-send-plane-line"></i><span>Pengajuan</span></a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Notifikasi Terbaru</h3>
                <a href="{{ route('guru.pengajuan') }}" class="card-link">Lihat semua</a>
            </div>
            @if (count($notif) === 0)
                <p class="empty-state">Tidak ada notifikasi baru</p>
            @else
                <div class="notif-list">
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
