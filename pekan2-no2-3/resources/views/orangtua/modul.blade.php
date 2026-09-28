@extends('layouts.mobile')

@php($diffColor = ['dasar' => '#3b82f6', 'menengah' => '#f59e0b', 'lanjut' => '#ef4444'])
@php($diffBg = ['dasar' => '#dbeafe', 'menengah' => '#fef3c7', 'lanjut' => '#fee2e2'])

@section('title', 'Panduan Latihan | InkluSkill')

@section('content')
<div class="mobile-page">
    {{-- tampilan daftar modul --}}
    <div id="modulListView">
        <p class="mobile-page-sub">Pilih modul untuk mulai latihan bersama anak</p>

        @if (count($modul) === 0)
            <div class="mobile-empty-state">
                <i class="ri-book-2-line"></i>
                <p>Belum ada modul tersedia</p>
            </div>
        @else
            <div class="mobile-modul-list">
                @foreach ($modul as $m)
                    <div class="mobile-modul-card" data-open-modul="{{ $loop->index }}" style="cursor:pointer">
                        <div class="mobile-modul-card-left">
                            <div class="mobile-modul-icon" style="background:{{ $diffBg[$m['tingkat_kesulitan']] }}">
                                <i class="ri-book-2-fill" style="color:{{ $diffColor[$m['tingkat_kesulitan']] }}"></i>
                            </div>
                            <div>
                                <div class="mobile-modul-title">{{ $m['judul_modul'] }}</div>
                                <div class="mobile-modul-meta">{{ $m['nama_keterampilan'] }}</div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem">
                            <span class="mobile-diff-tag" style="background:{{ $diffBg[$m['tingkat_kesulitan']] }};color:{{ $diffColor[$m['tingkat_kesulitan']] }}">
                                {{ $m['tingkat_kesulitan'] }}
                            </span>
                            <i class="ri-arrow-right-s-line" style="color:var(--text-light)"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- tampilan detail modul --}}
    @foreach ($modul as $m)
        <div class="modul-detail-view" data-modul="{{ $loop->index }}" style="display:none">
            <button type="button" class="mobile-back-btn" data-back-to-list>
                <i class="ri-arrow-left-line"></i> Kembali
            </button>

            <div class="mobile-modul-hero">
                <div class="mobile-modul-hero-tag" style="background:{{ $diffBg[$m['tingkat_kesulitan']] }};color:{{ $diffColor[$m['tingkat_kesulitan']] }}">
                    {{ $m['tingkat_kesulitan'] }}
                </div>
                <h2 class="mobile-modul-hero-title">{{ $m['judul_modul'] }}</h2>
                <p class="mobile-modul-hero-skill">{{ $m['nama_keterampilan'] }}</p>
                @if ($m['deskripsi'])
                    <p class="mobile-modul-hero-desc">{{ $m['deskripsi'] }}</p>
                @endif
                @if ($m['relevansi_industri'])
                    <div class="mobile-modul-industri">
                        <i class="ri-building-line"></i> {{ $m['relevansi_industri'] }}
                    </div>
                @endif
            </div>

            @if (count($anak) > 1)
                <div class="mobile-section">
                    <label class="mobile-label">Pilih Anak</label>
                    <select class="mobile-select">
                        @foreach ($anak as $a)
                            <option>{{ $a['nama_lengkap'] }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <h3 class="mobile-section-title">Langkah-langkah</h3>
            <div class="mobile-langkah-list">
                @foreach ($m['langkah'] as $l)
                    <div class="mobile-langkah-card">
                        <div class="mobile-langkah-num">{{ $l['urutan'] }}</div>
                        <div class="mobile-langkah-body">
                            <div class="mobile-langkah-title">{{ $l['judul_langkah'] }}</div>
                            @if ($l['deskripsi'])
                                <p class="mobile-langkah-desc">{{ $l['deskripsi'] }}</p>
                            @endif
                            @if (!empty($l['video_url']))
                                <a href="{{ $l['video_url'] }}" target="_blank" rel="noreferrer" class="mobile-video-btn">
                                    <i class="ri-play-circle-fill"></i> Tonton Video
                                </a>
                            @endif
                            <button type="button" class="mobile-selesai-btn">
                                Tandai Selesai
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var listView = document.getElementById('modulListView');

    document.querySelectorAll('[data-open-modul]').forEach(function (card) {
        card.addEventListener('click', function () {
            listView.style.display = 'none';
            document.querySelectorAll('.modul-detail-view').forEach(function (d) {
                d.style.display = d.dataset.modul === card.dataset.openModul ? '' : 'none';
            });
            window.scrollTo(0, 0);
        });
    });

    document.querySelectorAll('[data-back-to-list]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.modul-detail-view').forEach(function (d) { d.style.display = 'none'; });
            listView.style.display = '';
            window.scrollTo(0, 0);
        });
    });

    document.querySelectorAll('.mobile-selesai-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (btn.classList.contains('done')) return;
            btn.textContent = 'Menyimpan...';
            btn.disabled = true;
            setTimeout(function () {
                btn.classList.add('done');
                btn.textContent = '\u2713 Selesai';
                var card = btn.closest('.mobile-langkah-card');
                if (card) card.classList.add('done');
                var num = card ? card.querySelector('.mobile-langkah-num') : null;
                if (num) num.innerHTML = '<i class="ri-check-line"></i>';
            }, 600);
        });
    });
});
</script>
@endpush
