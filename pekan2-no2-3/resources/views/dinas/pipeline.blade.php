@extends('layouts.dashboard')

@php($tahapOrder = ['direkomendasikan', 'wawancara', 'penawaran', 'diterima', 'ditolak'])
@php($tahapColor = ['direkomendasikan' => '#3b82f6', 'wawancara' => '#f59e0b', 'penawaran' => '#8b5cf6', 'diterima' => '#10b981', 'ditolak' => '#ef4444'])
@php($tahapLabel = ['direkomendasikan' => 'Direkomendasikan', 'wawancara' => 'Wawancara', 'penawaran' => 'Penawaran', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'])
@php($tahapProgress = ['direkomendasikan' => 25, 'wawancara' => 50, 'penawaran' => 75, 'diterima' => 100, 'ditolak' => 0])

@section('title', 'Matching & Pipeline | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Matching & Pipeline</h1>
            <p class="page-subtitle">{{ count($pipeline) }} siswa dalam pipeline penyaluran</p>
        </div>
        <button type="button" class="btn btn-primary" data-open-modal="modalPipeline">
            <i class="ri-add-line"></i> Tambah ke Pipeline
        </button>
    </div>

    <div class="kanban-board">
        @foreach ($tahapOrder as $tahap)
            <div class="kanban-col">
                <div class="kanban-col-header" style="border-top:3px solid {{ $tahapColor[$tahap] }}">
                    <span style="font-weight:600">{{ $tahapLabel[$tahap] }}</span>
                    <span class="kanban-count">{{ collect($pipeline)->where('status_tahap', $tahap)->count() }}</span>
                </div>
                @foreach ($pipeline as $p)
                    @if ($p['status_tahap'] === $tahap)
                        <div class="kanban-card" data-open-update="{{ $loop->index }}" style="cursor:pointer">
                            <div style="font-weight:600;margin-bottom:0.25rem">{{ $p['nama_siswa'] }}</div>
                            <div style="font-size:0.8rem;color:var(--text-light)">{{ $p['kategori_disabilitas'] }}</div>
                            @if ($p['nama_perusahaan'])
                                <div style="font-size:0.8rem;margin-top:0.5rem">
                                    <i class="ri-building-line"></i> {{ $p['nama_perusahaan'] }}
                                </div>
                            @endif
                            @if (!is_null($p['persentase_match']))
                                <div style="margin-top:0.5rem">
                                    <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:var(--text-light);margin-bottom:3px">
                                        <span>Match {{ $p['persentase_match'] }}%</span>
                                        <span style="font-weight:600;color:{{ $tahapColor[$p['status_tahap']] }}">{{ $tahapProgress[$p['status_tahap']] }}%</span>
                                    </div>
                                    <div style="background:var(--extra-light);border-radius:99px;height:6px;overflow:hidden">
                                        <div style="width:{{ $tahapProgress[$p['status_tahap']] }}%;background:{{ $tahapColor[$p['status_tahap']] }};height:100%;border-radius:99px;transition:width 0.4s ease"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- modal tambah pipeline: input pengajuan + lowongan -> proses hitung match -> output kanban --}}
    <div class="modal-overlay" id="modalPipeline" style="display:none">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3>Tambah ke Pipeline</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>

            @if (session('error'))
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('dinas.pipeline.store') }}">
                @csrf
                <div class="form-group">
                    <label>Pengajuan (sudah diterima dinas)</label>
                    <select class="form-control" name="id_pengajuan" required>
                        <option value="">-- Pilih Pengajuan --</option>
                        @foreach ($pengajuan as $p)
                            <option value="{{ $p['id_pengajuan'] }}" {{ old('id_pengajuan') == $p['id_pengajuan'] ? 'selected' : '' }}>
                                {{ $p['nama_siswa'] }} — {{ $p['nama_sekolah'] }}
                            </option>
                        @endforeach
                    </select>
                    @if (count($pengajuan) === 0)
                        <small style="color:var(--text-light)">Belum ada pengajuan yang diterima. Guru harus mengajukan siswa dan dinas harus menerimanya terlebih dahulu.</small>
                    @endif
                </div>
                <div class="form-group">
                    <label>Lowongan Mitra</label>
                    <select class="form-control" name="id_lowongan" required>
                        <option value="">-- Pilih Lowongan --</option>
                        @foreach ($lowongan as $l)
                            <option value="{{ $l['id_lowongan'] }}" {{ old('id_lowongan') == $l['id_lowongan'] ? 'selected' : '' }}>
                                {{ $l['judul_posisi'] }} — {{ $l['nama_perusahaan'] }}
                            </option>
                        @endforeach
                    </select>
                    @if (count($lowongan) === 0)
                        <small style="color:var(--text-light)">Belum ada lowongan yang buka. Tambahkan dulu di menu Kelola Mitra.</small>
                    @endif
                </div>
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- modal update tahap: input status baru -> proses update -> output posisi kartu kanban berpindah --}}
    <div class="modal-overlay" id="modalUpdate" style="display:none">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 id="updateTitle">Update Status</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="" id="updateForm">
                @csrf
                <div class="form-group">
                    <label>Status Tahap</label>
                    <select class="form-control" name="status_tahap" id="updateTahap" required>
                        @foreach ($tahapOrder as $t)
                            <option value="{{ $t }}" {{ old('status_tahap') === $t ? 'selected' : '' }}>{{ $tahapLabel[$t] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea class="form-control" rows="3" name="catatan">{{ old('catatan') }}</textarea>
                </div>
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var pipeline = @json($pipeline);

    document.querySelectorAll('[data-open-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById(btn.dataset.openModal).style.display = 'flex';
        });
    });

    document.querySelectorAll('[data-open-update]').forEach(function (card) {
        card.addEventListener('click', function () {
            var p = pipeline[parseInt(card.dataset.openUpdate, 10)];
            document.getElementById('updateTitle').textContent = 'Update Status: ' + p.nama_siswa;
            document.getElementById('updateTahap').value = p.status_tahap;
            document.getElementById('updateForm').action = @json(url('dinas/pipeline')) + '/' + p.id_pipeline + '/update';
            document.getElementById('modalUpdate').style.display = 'flex';
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

    @if ($errors->any() || session('error'))
        document.getElementById('modalPipeline').style.display = 'flex';
    @endif
});
</script>
@endpush
