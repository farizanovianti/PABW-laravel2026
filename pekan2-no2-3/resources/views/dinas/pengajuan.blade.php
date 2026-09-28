@extends('layouts.dashboard')

@php($statusColor = ['diajukan' => '#f59e0b', 'diterima' => '#10b981', 'dikembalikan' => '#ef4444'])

@section('title', 'Pengajuan Masuk | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengajuan Masuk</h1>
            <p class="page-subtitle">{{ count($list) }} pengajuan {{ $filter ?: 'total' }}</p>
        </div>
    </div>

    {{-- filter status via query string, meniru GET /api/dinas/pengajuan?status= --}}
    <div class="filter-bar" style="margin-bottom:1.5rem">
        @foreach ([['v' => '', 'l' => 'Semua'], ['v' => 'diajukan', 'l' => 'Menunggu'], ['v' => 'diterima', 'l' => 'Diterima'], ['v' => 'dikembalikan', 'l' => 'Dikembalikan']] as $f)
            <a href="{{ $f['v'] ? route('dinas.pengajuan', ['status' => $f['v']]) : route('dinas.pengajuan') }}"
                class="filter-btn {{ ($filter ?: '') === $f['v'] ? 'active' : '' }}">{{ $f['l'] }}</a>
        @endforeach
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr><th>Siswa</th><th>Sekolah</th><th>Guru</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($list as $p)
                        <tr>
                            <td>
                                <a href="{{ route('dinas.siswa.show', $p['id_siswa']) }}" style="color:var(--primary-color);font-weight:500">
                                    {{ $p['nama_siswa'] }}
                                </a>
                                <div style="font-size:0.8rem;color:var(--text-light)">{{ $p['kategori_disabilitas'] }}</div>
                            </td>
                            <td>{{ $p['nama_sekolah'] }}</td>
                            <td>{{ $p['nama_guru'] }}</td>
                            <td>{{ explode(' ', $p['tanggal_pengajuan'])[0] }}</td>
                            <td>
                                <span class="badge" style="background:{{ $statusColor[$p['status']] }};color:white">{{ $p['status'] }}</span>
                                @if ($p['status'] !== 'diajukan')
                                    <div style="font-size:0.75rem;color:var(--text-light);margin-top:2px">
                                        {{ $p['catatan_dinas'] ? 'Catatan: '.$p['catatan_dinas'] : '' }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($p['status'] === 'diajukan')
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="openReview({{ $p['id_pengajuan'] }})">Review</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-light)">Tidak ada pengajuan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- modal review: input keputusan + catatan -> proses update pengajuan -> output status + notif guru + log sistem --}}
    <div class="modal-overlay" id="modalReview" style="display:none">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 id="reviewTitle">Review Pengajuan</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>
            <div id="reviewInfo" style="padding:0.75rem;background:var(--bg-soft);border-radius:8px;margin-bottom:1rem"></div>

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="" id="reviewForm">
                @csrf
                <div class="form-group">
                    <label>Keputusan</label>
                    <div style="display:flex;gap:1rem">
                        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                            <input type="radio" name="status" value="diterima" {{ old('status', 'diterima') === 'diterima' ? 'checked' : '' }}> Terima
                        </label>
                        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                            <input type="radio" name="status" value="dikembalikan" {{ old('status') === 'dikembalikan' ? 'checked' : '' }}> Kembalikan
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea class="form-control" rows="3" name="catatan"
                        placeholder="Catatan untuk guru...">{{ old('catatan') }}</textarea>
                </div>
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
var pengajuanList = @json($list);

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) overlay.style.display = 'none';
        });
    });
    document.querySelectorAll('[data-close-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.modal-overlay').style.display = 'none';
        });
    });

    @if ($errors->any() && old('id_pengajuan'))
        openReview({{ old('id_pengajuan') }});
    @endif
});

function openReview(idPengajuan) {
    var p = pengajuanList.find(function (x) { return x.id_pengajuan == idPengajuan; });
    if (!p) return true;

    document.getElementById('reviewTitle').textContent = 'Review Pengajuan: ' + p.nama_siswa;
    document.getElementById('reviewInfo').innerHTML =
        '<strong>' + p.nama_siswa + '</strong> &bull; ' + p.kategori_disabilitas + '<br>' +
        '<small style="color:var(--text-light)">Diajukan oleh ' + p.nama_guru + ' dari ' + p.nama_sekolah + '</small>' +
        (p.keterangan ? '<p style="margin-top:0.5rem">' + p.keterangan + '</p>' : '');

    document.getElementById('reviewForm').action = @json(url('dinas/pengajuan')) + '/' + idPengajuan + '/review';
    document.getElementById('modalReview').style.display = 'flex';
    return false;
}
</script>
@endpush
