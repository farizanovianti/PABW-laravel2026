@extends('layouts.mobile')

@php($levelOrder = ['belum' => 0, 'dasar' => 1, 'mahir' => 2, 'ahli' => 3])
@php($levelColor = ['belum' => '#e2e8f0', 'dasar' => '#93c5fd', 'mahir' => '#fbbf24', 'ahli' => '#34d399'])
@php($levelLabel = ['belum' => 'Belum', 'dasar' => 'Dasar', 'mahir' => 'Mahir', 'ahli' => 'Ahli'])

@section('title', 'Jalur Kemandirian | InkluSkill')

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

    <div class="mobile-legend-row">
        @foreach ($levelLabel as $k => $v)
            <div class="mobile-legend-item">
                <div class="mobile-legend-dot" style="background:{{ $levelColor[$k] }}"></div>
                <span>{{ $v }}</span>
            </div>
        @endforeach
    </div>

    @foreach ($anak as $i => $siswa)
        @php($jalur = $jalurPerAnak[$siswa['id_siswa']] ?? [])
        <div class="jalur-detail" data-anak="{{ $i }}" style="{{ $loop->first ? '' : 'display:none' }}">
            <div class="mobile-jalur-hero">
                <div class="mobile-jalur-avatar">{{ mb_substr($siswa['nama_lengkap'], 0, 1) }}</div>
                <div>
                    <div class="mobile-jalur-name">{{ $siswa['nama_lengkap'] }}</div>
                    <div class="mobile-jalur-meta">{{ $siswa['kategori_disabilitas'] }} &bull; {{ $siswa['kelas'] }}</div>
                </div>
            </div>

            @if (count($jalur) === 0)
                <div class="mobile-empty-state">
                    <i class="ri-route-line"></i>
                    <p>Belum ada data jalur kemandirian</p>
                </div>
            @endif

            @foreach ($jalur as $j)
                @php($pct = (int) round(($levelOrder[$j['level_max']] / 3) * 100))
                <div class="mobile-jalur-card">
                    <div class="mobile-jalur-card-top">
                        <div>
                            <div class="mobile-jalur-skill">{{ $j['nama_keterampilan'] }}</div>
                            <div class="mobile-jalur-kategori">{{ $j['kategori'] }} &bull; {{ $j['jumlah_sesi'] }} sesi</div>
                        </div>
                        <span class="mobile-level-badge" style="background:{{ $levelColor[$j['level_max']] }};color:{{ $j['level_max'] === 'belum' ? '#64748b' : 'white' }}">
                            {{ $levelLabel[$j['level_max']] }}
                        </span>
                    </div>
                    <div class="mobile-jalur-bar">
                        <div class="mobile-jalur-bar-fill" style="width:{{ $pct }}%;background:{{ $levelColor[$j['level_max']] }}"></div>
                    </div>
                    <div class="mobile-jalur-steps">
                        @foreach (['belum', 'dasar', 'mahir', 'ahli'] as $l)
                            @php($done = $levelOrder[$j['level_max']] >= $levelOrder[$l])
                            <div class="mobile-jalur-step {{ $done ? 'done' : '' }}" style="{{ $done ? 'background:'.$levelColor[$l] : '' }}">
                                @if ($l === $j['level_max'])
                                    <i class="ri-check-line"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.mobile-chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            var idx = chip.dataset.anak;
            document.querySelectorAll('.mobile-chip').forEach(function (c) {
                c.classList.toggle('active', c.dataset.anak === idx);
            });
            document.querySelectorAll('.jalur-detail').forEach(function (d) {
                d.style.display = d.dataset.anak === idx ? '' : 'none';
            });
        });
    });
});
</script>
@endpush
