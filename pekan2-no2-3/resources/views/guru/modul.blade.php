@extends('layouts.dashboard')

@php($diffColor = ['dasar' => '#3b82f6', 'menengah' => '#f59e0b', 'lanjut' => '#ef4444'])

@section('title', 'Modul Ajar | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Modul Ajar</h1>
            <p class="page-subtitle">Panduan pengajaran keterampilan vokasional</p>
        </div>
    </div>

    <div class="grid grid-2" style="gap:1.5rem">
        <div>
            <div class="card" style="margin-bottom:1rem">
                <select class="form-control" id="filterSkill">
                    <option value="">Semua Keterampilan</option>
                    @foreach ($keterampilan as $k)
                        <option value="{{ $k['id_keterampilan'] }}">{{ $k['nama_keterampilan'] }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex;flex-direction:column;gap:0.75rem" id="modulList">
                @forelse ($modul as $m)
                    <div class="modul-item card {{ $loop->first ? 'selected' : '' }}"
                        data-modul="{{ $loop->index }}"
                        data-skill="{{ $m['id_keterampilan'] }}"
                        style="cursor:pointer;border:{{ $loop->first ? '2px solid var(--primary-color)' : '2px solid transparent' }}">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start">
                            <div>
                                <div style="font-weight:600">{{ $m['judul_modul'] }}</div>
                                <div style="font-size:0.85rem;color:var(--text-light)">{{ $m['nama_keterampilan'] }}</div>
                            </div>
                            <span class="badge" style="background:{{ $diffColor[$m['tingkat_kesulitan']] }};color:white">
                                {{ $m['tingkat_kesulitan'] }}
                            </span>
                        </div>
                        @if ($m['relevansi_industri'])
                            <div style="margin-top:0.5rem;font-size:0.8rem;color:var(--text-light)">
                                <i class="ri-building-line"></i> {{ $m['relevansi_industri'] }}
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="empty-state">Tidak ada modul</p>
                @endforelse
            </div>
        </div>

        <div>
            @if (count($modul) > 0)
                <div class="card modul-detail" data-detail="{{ $loop ? 0 : 0 }}">
                    @foreach ($modul as $m)
                        <div class="modul-detail-panel" data-detail="{{ $loop->index }}" style="{{ $loop->first ? '' : 'display:none' }}">
                            <h3 style="margin-bottom:0.5rem">{{ $m['judul_modul'] }}</h3>
                            <div style="display:flex;gap:0.5rem;margin-bottom:1rem">
                                <span class="badge badge-info">{{ $m['nama_keterampilan'] }}</span>
                                <span class="badge" style="background:{{ $diffColor[$m['tingkat_kesulitan']] }};color:white">
                                    {{ $m['tingkat_kesulitan'] }}
                                </span>
                            </div>
                            @if ($m['deskripsi'])
                                <p style="color:var(--text-light);margin-bottom:1rem">{{ $m['deskripsi'] }}</p>
                            @endif
                            @if ($m['relevansi_industri'])
                                <p style="font-size:0.85rem;margin-bottom:1.5rem">
                                    <i class="ri-building-line"></i> Relevan untuk: {{ $m['relevansi_industri'] }}
                                </p>
                            @endif

                            <h4 style="margin-bottom:0.75rem">Langkah-langkah Pengajaran</h4>
                            <div class="langkah-list">
                                @foreach ($m['langkah'] as $l)
                                    <div class="langkah-item">
                                        <div class="langkah-num">{{ $l['urutan'] }}</div>
                                        <div class="langkah-content">
                                            <div class="langkah-title">{{ $l['judul_langkah'] }}</div>
                                            @if ($l['deskripsi'])
                                                <p class="langkah-desc">{{ $l['deskripsi'] }}</p>
                                            @endif
                                            @if (!empty($l['tip_guru']))
                                                <div class="tip-guru">
                                                    <i class="ri-lightbulb-line"></i> <strong>Tip Guru:</strong> {{ $l['tip_guru'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card">
                    <div class="empty-state">
                        <i class="ri-book-open-line" style="font-size:3rem;color:var(--extra-light)"></i>
                        <p>Pilih modul untuk melihat detail</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var items = document.querySelectorAll('#modulList .modul-item');
    var panels = document.querySelectorAll('.modul-detail-panel');

    items.forEach(function (item) {
        item.addEventListener('click', function () {
            items.forEach(function (i) {
                i.classList.remove('selected');
                i.style.border = '2px solid transparent';
            });
            item.classList.add('selected');
            item.style.border = '2px solid var(--primary-color)';
            var idx = item.dataset.modul;
            panels.forEach(function (p) { p.style.display = p.dataset.detail === idx ? '' : 'none'; });
        });
    });

    document.getElementById('filterSkill').addEventListener('change', function () {
        var v = this.value;
        items.forEach(function (item) {
            item.style.display = !v || item.dataset.skill === v ? '' : 'none';
        });
    });
});
</script>
@endpush
