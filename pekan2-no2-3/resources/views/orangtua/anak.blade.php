@extends('layouts.mobile')

@php($levelColor = ['belum' => '#94a3b8', 'dasar' => '#3b82f6', 'mahir' => '#f59e0b', 'ahli' => '#10b981'])
@php($levelLabel = ['belum' => 'Belum', 'dasar' => 'Dasar', 'mahir' => 'Mahir', 'ahli' => 'Ahli'])
@php($tahapColor = ['direkomendasikan' => '#3b82f6', 'wawancara' => '#f59e0b', 'penawaran' => '#8b5cf6', 'diterima' => '#10b981', 'ditolak' => '#ef4444'])

@section('title', 'Profil Anak | InkluSkill')

@section('content')
<div class="mobile-page">
    @if (count($anak) > 1)
        <div class="mobile-chip-row">
            @foreach ($anak as $a)
                <button type="button" class="mobile-chip {{ $loop->first ? 'active' : '' }}" data-anak="{{ $loop->index }}">
                    {{ explode(' ', $a['nama_lengkap'])[0] }}
                </button>
            @endforeach
        </div>
    @endif

    @foreach ($details as $i => $detail)
        <div class="anak-detail" data-anak="{{ $i }}" style="{{ $loop->first ? '' : 'display:none' }}">
            <div class="mobile-profil-hero">
                <div class="mobile-profil-hero-avatar">{{ mb_substr($detail['nama_lengkap'], 0, 1) }}</div>
                <h2 class="mobile-profil-hero-name">{{ $detail['nama_lengkap'] }}</h2>
                <p class="mobile-profil-hero-meta">{{ $detail['kategori_disabilitas'] }}</p>
                <p class="mobile-profil-hero-meta">{{ $detail['kelas'] }} &bull; {{ $detail['nama_sekolah'] }}</p>
                <div class="mobile-profil-badges">
                    <span class="mobile-badge-green">{{ $detail['status'] }}</span>
                    @if ($detail['tahun_masuk'])
                        <span class="mobile-badge-blue">Masuk {{ $detail['tahun_masuk'] }}</span>
                    @endif
                </div>
            </div>

            <div class="mobile-stats-row">
                <div class="mobile-stat-box">
                    <div class="mobile-stat-val">{{ count($detail['kompetensi_tervalidasi']) }}</div>
                    <div class="mobile-stat-lbl">Kompetensi</div>
                </div>
                <div class="mobile-stat-box">
                    <div class="mobile-stat-val">{{ count($detail['pipeline']) }}</div>
                    <div class="mobile-stat-lbl">Pipeline</div>
                </div>
            </div>

            <div class="mobile-tab-row">
                <button type="button" class="mobile-tab active" data-tab="kompetensi">Kompetensi</button>
                <button type="button" class="mobile-tab" data-tab="pipeline">Status Kerja</button>
            </div>

            <div class="mobile-tab-panel" data-panel="kompetensi">
                @if (count($detail['kompetensi_tervalidasi']) === 0)
                    <div class="mobile-empty-state"><i class="ri-shield-line"></i><p>Belum ada kompetensi tervalidasi</p></div>
                @else
                    @foreach ($detail['kompetensi_tervalidasi'] as $v)
                        <div class="mobile-kompetensi-card">
                            <div class="mobile-kompetensi-top">
                                <span class="mobile-kompetensi-nama">{{ $v['nama_keterampilan'] }}</span>
                                <span class="mobile-level-badge" style="background:{{ $levelColor[$v['level_tercapai']] }}">
                                    {{ $levelLabel[$v['level_tercapai']] }}
                                </span>
                            </div>
                            <div class="mobile-kompetensi-validator">
                                <i class="ri-shield-check-fill" style="color:var(--success)"></i>
                                Divalidasi oleh {{ $v['nama_validator'] }} &bull; {{ explode(' ', $v['tanggal_validasi'])[0] }}
                            </div>
                            @if ($v['catatan_validasi'])
                                <div class="mobile-kompetensi-catatan">{{ $v['catatan_validasi'] }}</div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="mobile-tab-panel" data-panel="pipeline" style="display:none">
                @if (count($detail['pipeline']) === 0)
                    <div class="mobile-empty-state"><i class="ri-briefcase-line"></i><p>Belum ada pengajuan ke mitra</p></div>
                @else
                    @foreach ($detail['pipeline'] as $p)
                        <div class="mobile-pipeline-card">
                            <div class="mobile-pipeline-top">
                                <div>
                                    <div class="mobile-pipeline-nama">{{ $p['nama_perusahaan'] ?: 'Menunggu pencocokan' }}</div>
                                    @if ($p['judul_posisi'])
                                        <div class="mobile-pipeline-posisi">{{ $p['judul_posisi'] }}</div>
                                    @endif
                                </div>
                                <span class="mobile-level-badge" style="background:{{ $tahapColor[$p['status_tahap']] }}">
                                    {{ $p['status_tahap'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function activate(index) {
        document.querySelectorAll('.mobile-chip').forEach(function (c) {
            c.classList.toggle('active', c.dataset.anak === index);
        });
        document.querySelectorAll('.anak-detail').forEach(function (d) {
            d.style.display = d.dataset.anak === index ? '' : 'none';
        });
    }

    document.querySelectorAll('.mobile-chip').forEach(function (chip) {
        chip.addEventListener('click', function () { activate(chip.dataset.anak); });
    });

    // tab per panel detail
    document.querySelectorAll('.anak-detail').forEach(function (detail) {
        detail.querySelectorAll('.mobile-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                detail.querySelectorAll('.mobile-tab').forEach(function (t) { t.classList.remove('active'); });
                detail.querySelectorAll('.mobile-tab-panel').forEach(function (p) { p.style.display = 'none'; });
                tab.classList.add('active');
                detail.querySelector('.mobile-tab-panel[data-panel="' + tab.dataset.tab + '"]').style.display = '';
            });
        });
    });
});
</script>
@endpush
