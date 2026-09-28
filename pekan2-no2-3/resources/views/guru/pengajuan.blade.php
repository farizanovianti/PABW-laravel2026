@extends('layouts.dashboard')

@php($statusColor = ['diajukan' => '#f59e0b', 'diterima' => '#10b981', 'dikembalikan' => '#ef4444'])

@section('title', 'Laporan & Pengajuan | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan & Pengajuan ke Dinas</h1>
            <p class="page-subtitle">{{ count($pengajuan) }} total pengajuan</p>
        </div>
        <button type="button" class="btn btn-primary" data-open-modal="modalAjukan">
            <i class="ri-add-line"></i> Ajukan Siswa
        </button>
    </div>

    <div class="grid grid-3" style="margin-bottom:2rem">
        @foreach ([['status' => 'diajukan', 'label' => 'Menunggu Review'], ['status' => 'diterima', 'label' => 'Diterima'], ['status' => 'dikembalikan', 'label' => 'Dikembalikan']] as $s)
            <div class="stat-card">
                <div class="stat-value" style="color:{{ $statusColor[$s['status']] }}">
                    {{ collect($pengajuan)->where('status', $s['status'])->count() }}
                </div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="card">
        @if (count($pengajuan) === 0)
            <div class="empty-state">
                <i class="ri-send-plane-line" style="font-size:3rem;color:var(--extra-light)"></i>
                <p>Belum ada pengajuan</p>
            </div>
        @else
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Sekolah</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Catatan Dinas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuan as $p)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.5rem">
                                        <div class="avatar-sm">{{ mb_substr($p['nama_siswa'], 0, 1) }}</div>
                                        {{ $p['nama_siswa'] }}
                                    </div>
                                </td>
                                <td>{{ $p['nama_sekolah'] }}</td>
                                <td>{{ explode(' ', $p['tanggal_pengajuan'])[0] }}</td>
                                <td>
                                    <span class="badge" style="background:{{ $statusColor[$p['status']] }};color:white">
                                        {{ $p['status'] }}
                                    </span>
                                </td>
                                <td>{{ $p['catatan_dinas'] ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- modal ajukan: input siswa + keterangan -> proses store -> output tabel pengajuan & notif dinas --}}
    <div class="modal-overlay" id="modalAjukan" style="display:none">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3>Ajukan Siswa ke Dinas</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('guru.pengajuan.store') }}">
                @csrf
                <div class="form-group">
                    <label>Pilih Siswa</label>
                    <select class="form-control" name="id_siswa" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswa as $s)
                            <option value="{{ $s['id_siswa'] }}" {{ old('id_siswa') == $s['id_siswa'] ? 'selected' : '' }}>
                                {{ $s['nama_lengkap'] }} ({{ $s['kategori_disabilitas'] ?: 'ABK' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Keterangan Pengajuan</label>
                    <textarea class="form-control" rows="4" name="keterangan"
                        placeholder="Jelaskan kemampuan dan kesiapan siswa untuk disalurkan ke mitra industri...">{{ old('keterangan') }}</textarea>
                </div>
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-open-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById(btn.dataset.openModal).style.display = 'flex';
        });
    });
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

    @if ($errors->any())
        document.getElementById('modalAjukan').style.display = 'flex';
    @endif
});
</script>
@endpush
