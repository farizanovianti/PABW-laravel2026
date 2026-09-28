@extends('layouts.mobile')

@section('title', 'Beranda Orang Tua | InkluSkill')

@php($anak = $stats['anak'][0] ?? null)

@section('content')
<div class="mobile-page">
    <div class="mobile-greeting">
        <div>
            <p class="mobile-greeting-sub">Halo,</p>
            <h2 class="mobile-greeting-name">{{ explode(' ', $user['name'])[0] }} &#128075;</h2>
        </div>
        <a href="{{ route('orangtua.anak') }}" class="mobile-avatar-btn">
            <div class="mobile-user-avatar">{{ mb_substr($user['name'], 0, 1) }}</div>
        </a>
    </div>

    @if ($anak)
        <div class="mobile-anak-card">
            <div class="mobile-anak-card-left">
                <div class="mobile-anak-avatar">{{ mb_substr($anak['nama_lengkap'], 0, 1) }}</div>
                <div>
                    <div class="mobile-anak-name">{{ $anak['nama_lengkap'] }}</div>
                    <div class="mobile-anak-meta">{{ $anak['kategori_disabilitas'] }}</div>
                    <div class="mobile-anak-meta">{{ $anak['kelas'] }} &bull; {{ $anak['nama_sekolah'] }}</div>
                </div>
            </div>
            <a href="{{ route('orangtua.anak') }}" class="mobile-anak-btn">
                <i class="ri-arrow-right-s-line"></i>
            </a>
        </div>
    @endif

    <div class="mobile-stats-row">
        <div class="mobile-stat-box">
            <div class="mobile-stat-val">{{ $stats['total_aktivitas'] }}</div>
            <div class="mobile-stat-lbl">Aktivitas</div>
        </div>
        <div class="mobile-stat-box">
            <div class="mobile-stat-val" style="color:var(--success)">{{ $stats['kompetensi_tervalidasi'] }}</div>
            <div class="mobile-stat-lbl">Tervalidasi</div>
        </div>
        <div class="mobile-stat-box">
            <div class="mobile-stat-val" style="color:var(--primary-color)">{{ $stats['total_anak'] }}</div>
            <div class="mobile-stat-lbl">Anak</div>
        </div>
    </div>

    <h3 class="mobile-section-title">Menu</h3>
    <div class="mobile-menu-grid">
        @foreach ([
            ['route' => 'orangtua.jalur', 'icon' => 'ri-route-fill', 'label' => 'Jalur Kemandirian', 'color' => '#059669', 'bg' => '#d1fae5'],
            ['route' => 'orangtua.modul', 'icon' => 'ri-book-2-fill', 'label' => 'Panduan Latihan', 'color' => '#d97706', 'bg' => '#fef3c7'],
            ['route' => 'orangtua.anak', 'icon' => 'ri-user-heart-fill', 'label' => 'Profil Anak', 'color' => '#0891b2', 'bg' => '#cffafe'],
        ] as $m)
            <a href="{{ route($m['route']) }}" class="mobile-menu-item">
                <div class="mobile-menu-icon" style="background:{{ $m['bg'] }}">
                    <i class="{{ $m['icon'] }}" style="color:{{ $m['color'] }}"></i>
                </div>
                <span>{{ $m['label'] }}</span>
            </a>
        @endforeach
    </div>

    <div class="mobile-section-header">
        <h3 class="mobile-section-title" style="margin-bottom:0">Aktivitas Terbaru</h3>
    </div>
    <div class="mobile-recent-list">
        <a href="{{ route('orangtua.anak') }}" class="mobile-recent-item">
            <div class="mobile-recent-icon" style="background:#ede9fe">
                <i class="ri-calendar-check-line" style="color:#7c3aed"></i>
            </div>
            <div class="mobile-recent-info">
                <div class="mobile-recent-title">Lihat semua aktivitas</div>
                <div class="mobile-recent-sub">Profil &amp; progres perkembangan anak</div>
            </div>
            <i class="ri-arrow-right-s-line" style="color:var(--text-light)"></i>
        </a>
    </div>
</div>
@endsection
