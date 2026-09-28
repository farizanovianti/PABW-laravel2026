@extends('layouts.dashboard')

@php($levelColor = ['belum' => '#94a3b8', 'dasar' => '#3b82f6', 'mahir' => '#f59e0b', 'ahli' => '#10b981'])

@section('title', 'Validasi Kompetensi | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Validasi Kompetensi</h1>
            <p class="page-subtitle">{{ count($pending) }} log menunggu validasi</p>
        </div>
    </div>

    @if (count($pending) === 0)
        <div class="card">
            <div class="empty-state">
                <i class="ri-checkbox-circle-line" style="font-size:3rem;color:var(--success)"></i>
                <p>Semua log sudah tervalidasi</p>
            </div>
        </div>
    @else
        <div class="validasi-grid">
            @foreach ($pending as $log)
                <div class="validasi-card card">
                    <div class="validasi-card-header">
                        <div class="avatar-sm">{{ mb_substr($log['nama_siswa'], 0, 1) }}</div>
                        <div>
                            <div class="validasi-siswa">{{ $log['nama_siswa'] }}</div>
                            <div class="validasi-tanggal">{{ $log['tanggal_sesi'] }}</div>
                        </div>
                    </div>
                    <div class="validasi-skill">
                        <span>{{ $log['nama_keterampilan'] }}</span>
                        <span class="badge" style="background:{{ $levelColor[$log['level_tercapai']] }};color:white">
                            {{ $log['level_tercapai'] }}
                        </span>
                    </div>
                    @if ($log['catatan_guru'])
                        <p class="validasi-catatan">{{ $log['catatan_guru'] }}</p>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm" style="width:100%;margin-top:0.75rem"
                        data-open-validasi="{{ $loop->index }}">
                        <i class="ri-shield-check-line"></i> Validasi
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    {{-- modal validasi: input keputusan -> proses update status log -> output kompetensi tervalidasi --}}
    <div class="modal-overlay" id="modalValidasi" style="display:none">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 id="validasiTitle">Validasi</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>
            <div style="margin-bottom:1rem;padding:0.75rem;background:var(--bg-soft);border-radius:8px" id="validasiInfo"></div>

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('guru.validasi.store') }}">
                @csrf
                <input type="hidden" name="id_log" id="validasiIdLog" value="{{ old('id_log') }}">

                <div class="form-group">
                    <label>Keputusan</label>
                    <div style="display:flex;gap:1rem">
                        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                            <input type="radio" name="keputusan" value="disetujui" {{ old('keputusan', 'disetujui') === 'disetujui' ? 'checked' : '' }}>
                            <span class="keputusan-label" data-color="var(--success)">Setujui</span>
                        </label>
                        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer">
                            <input type="radio" name="keputusan" value="perlu_revisi" {{ old('keputusan') === 'perlu_revisi' ? 'checked' : '' }}>
                            <span class="keputusan-label" data-color="var(--danger)">Perlu Revisi</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Catatan Validasi</label>
                    <textarea class="form-control" rows="3" name="catatan_validasi"
                        placeholder="Catatan untuk siswa dan orang tua...">{{ old('catatan_validasi') }}</textarea>
                </div>
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Validasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var pending = @json($pending);
    var levelColor = @json($levelColor);
    var modal = document.getElementById('modalValidasi');

    function fill(log) {
        document.getElementById('validasiTitle').textContent = 'Validasi: ' + log.nama_siswa;
        document.getElementById('validasiIdLog').value = log.id_log;
        document.getElementById('validasiInfo').innerHTML =
            '<strong>' + log.nama_keterampilan + '</strong> &bull;' +
            '<span class="badge" style="background:' + levelColor[log.level_tercapai] + ';color:white;margin:0 0.5rem">' + log.level_tercapai + '</span>' +
            '<br><small>' + log.tanggal_sesi + '</small>' +
            (log.catatan_guru ? '<p style="margin-top:0.5rem;color:var(--text-light)">' + log.catatan_guru + '</p>' : '');
    }

    document.querySelectorAll('[data-open-validasi]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            fill(pending[parseInt(btn.dataset.openValidasi, 10)]);
            modal.style.display = 'flex';
        });
    });

    document.querySelectorAll('.keputusan-label').forEach(function (span) {
        var input = span.parentElement.querySelector('input');
        function paint() {
            document.querySelectorAll('.keputusan-label').forEach(function (s) {
                s.style.color = '';
                s.style.fontWeight = 400;
            });
            span.style.color = span.dataset.color;
            span.style.fontWeight = 600;
        }
        input.addEventListener('change', paint);
        if (input.checked) paint();
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) modal.style.display = 'none';
    });
    document.querySelectorAll('[data-close-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.modal-overlay').style.display = 'none';
        });
    });

    @if ($errors->any())
        // buka kembali modal validasi setelah gagal
        var log = pending.find(function (l) { return l.id_log == {{ old('id_log') ?? 0 }}; });
        if (log) fill(log);
        modal.style.display = 'flex';
    @endif
});
</script>
@endpush
