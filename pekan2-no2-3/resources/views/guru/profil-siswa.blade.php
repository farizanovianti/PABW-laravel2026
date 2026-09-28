@extends('layouts.dashboard')

@php($levelColor = ['belum' => '#94a3b8', 'dasar' => '#3b82f6', 'mahir' => '#f59e0b', 'ahli' => '#10b981'])
@php($levelLabel = ['belum' => 'Belum', 'dasar' => 'Dasar', 'mahir' => 'Mahir', 'ahli' => 'Ahli'])

@section('title', 'Profil Siswa | InkluSkill')

@section('content')
<div>
    <button type="button" class="btn btn-outline btn-sm" onclick="history.back()" style="margin-bottom:1rem">
        <i class="ri-arrow-left-line"></i> Kembali
    </button>

    <div class="profil-header card">
        <div class="profil-avatar">{{ mb_substr($siswa['nama_lengkap'], 0, 1) }}</div>
        <div class="profil-info">
            <h2>{{ $siswa['nama_lengkap'] }}</h2>
            <p>{{ $siswa['kategori_disabilitas'] }} &bull; {{ $siswa['kelas'] }} &bull; {{ $siswa['nama_sekolah'] }}</p>
            <div style="display:flex;gap:0.5rem;margin-top:0.5rem">
                <span class="badge badge-{{ $siswa['status'] === 'aktif' ? 'success' : 'warning' }}">{{ $siswa['status'] }}</span>
                @if (count($pipeline) > 0)
                    <span class="badge badge-info">Pipeline: {{ $pipeline[0]['status_tahap'] }}</span>
                @endif
            </div>
        </div>
        <button type="button" class="btn btn-primary" data-open-modal="modalLog">
            <i class="ri-add-line"></i> Input Log Aktivitas
        </button>
    </div>

    <div class="modal-overlay" id="modalLog" style="display:none">
        <div class="modal-card" style="max-width:560px" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3>Input Log Aktivitas &mdash; {{ $siswa['nama_lengkap'] }}</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('guru.log.store') }}">
                @csrf
                <input type="hidden" name="id_siswa" value="{{ $siswa['id_siswa'] }}">

                <div class="form-group">
                    <label>Keterampilan</label>
                    <select class="form-control" name="id_keterampilan" required>
                        <option value="">-- Pilih Keterampilan --</option>
                        @foreach ($keterampilan as $k)
                            <option value="{{ $k['id_keterampilan'] }}" {{ old('id_keterampilan') == $k['id_keterampilan'] ? 'selected' : '' }}>
                                {{ $k['nama_keterampilan'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Level Tercapai</label>
                    <div class="level-selector" id="levelSelector">
                        @foreach (['belum', 'dasar', 'mahir', 'ahli'] as $l)
                            <label class="level-option {{ old('level_tercapai', 'dasar') === $l ? 'active' : '' }}" data-level="{{ $l }}"
                                style="{{ old('level_tercapai', 'dasar') === $l ? 'background:'.$levelColor[$l].';color:white;border-color:'.$levelColor[$l] : '' }}">
                                <input type="radio" name="level_tercapai" value="{{ $l }}"
                                    {{ old('level_tercapai', 'dasar') === $l ? 'checked' : '' }} style="display:none">
                                {{ $levelLabel[$l] }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Sesi</label>
                    <input type="date" class="form-control" name="tanggal_sesi"
                        value="{{ old('tanggal_sesi', now()->toDateString()) }}" required>
                </div>

                <div class="form-group">
                    <label>Catatan Observasi</label>
                    <textarea class="form-control" rows="3" name="catatan_guru"
                        placeholder="Deskripsikan aktivitas yang dilakukan siswa...">{{ old('catatan_guru') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Foto / Video Bukti Aktivitas</label>
                    <div class="media-upload-area">
                        <label class="media-upload-btn">
                            <i class="ri-image-add-line"></i>
                            <span>Tambah Foto/Video</span>
                            <small>JPG, PNG, MP4 (maks. 10MB)</small>
                            <input type="file" accept="image/*,video/*" multiple style="display:none" id="mediaUpload">
                        </label>
                    </div>
                    <div class="media-preview-grid" id="mediaPreview" style="margin-top:0.75rem"></div>
                </div>

                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Log</button>
                </div>
            </form>
        </div>
    </div>

    <div class="tabs">
        <button type="button" class="tab-btn active" data-tab="log">Log Aktivitas</button>
        <button type="button" class="tab-btn" data-tab="kompetensi">Kompetensi Tervalidasi</button>
        <button type="button" class="tab-btn" data-tab="pipeline">Status Pengajuan</button>
    </div>

    {{-- tab log --}}
    <div class="card tab-panel" data-panel="log">
        @if (count($log_aktivitas) === 0)
            <p class="empty-state">Belum ada log aktivitas</p>
        @else
            <div class="log-list">
                @foreach ($log_aktivitas as $l)
                    <div class="log-item">
                        <div class="log-date">{{ $l['tanggal_sesi'] }}</div>
                        <div class="log-content">
                            <div class="log-skill">{{ $l['nama_keterampilan'] }}</div>
                            <div style="display:flex;gap:0.4rem;flex-wrap:wrap;margin-top:0.25rem">
                                <span class="badge" style="background:{{ $levelColor[$l['level_tercapai']] }};color:white">
                                    {{ $levelLabel[$l['level_tercapai']] }}
                                </span>
                                <span class="badge badge-{{ $l['status_validasi'] === 'tervalidasi' ? 'success' : ($l['status_validasi'] === 'perlu_revisi' ? 'danger' : 'warning') }}">
                                    {{ $l['status_validasi'] }}
                                </span>
                            </div>
                            @if ($l['catatan_guru'])
                                <p class="log-catatan">{{ $l['catatan_guru'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- tab kompetensi --}}
    <div class="card tab-panel" data-panel="kompetensi" style="display:none">
        @if (count($kompetensi_validated) === 0)
            <p class="empty-state">Belum ada kompetensi yang tervalidasi</p>
        @else
            <div class="grid grid-2">
                @foreach ($kompetensi_validated as $v)
                    <div class="kompetensi-card">
                        <div class="kompetensi-skill">{{ $v['nama_keterampilan'] }}</div>
                        <span class="badge" style="background:{{ $levelColor[$v['level_tercapai']] }};color:white">
                            {{ $levelLabel[$v['level_tercapai']] }}
                        </span>
                        <div class="kompetensi-date">Divalidasi: {{ explode(' ', $v['tanggal_validasi'])[0] }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- tab pipeline --}}
    <div class="card tab-panel" data-panel="pipeline" style="display:none">
        @if (count($pipeline) === 0)
            <p class="empty-state">Belum ada pengajuan ke dinas</p>
        @else
            @foreach ($pipeline as $p)
                <div class="pipeline-item">
                    <div>
                        @if ($p['nama_perusahaan'])
                            <strong>{{ $p['nama_perusahaan'] }}</strong>
                        @endif
                        @if ($p['judul_posisi'])
                            <span> &mdash; {{ $p['judul_posisi'] }}</span>
                        @endif
                    </div>
                    <span class="badge badge-pipeline">{{ $p['status_tahap'] }}</span>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // tabs
    document.querySelectorAll('.tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
            document.querySelectorAll('.tab-panel').forEach(function (p) { p.style.display = 'none'; });
            btn.classList.add('active');
            document.querySelector('.tab-panel[data-panel="' + btn.dataset.tab + '"]').style.display = '';
        });
    });

    // level selector
    var colors = @json($levelColor);
    document.querySelectorAll('#levelSelector .level-option').forEach(function (opt) {
        opt.addEventListener('click', function () {
            document.querySelectorAll('#levelSelector .level-option').forEach(function (o) {
                o.classList.remove('active');
                o.style.background = '';
                o.style.color = '';
                o.style.borderColor = '';
            });
            opt.classList.add('active');
            opt.querySelector('input').checked = true;
            var c = colors[opt.dataset.level];
            opt.style.background = c;
            opt.style.color = 'white';
            opt.style.borderColor = c;
        });
    });

    // media upload preview
    var upload = document.getElementById('mediaUpload');
    if (upload) {
        upload.addEventListener('change', function () {
            var grid = document.getElementById('mediaPreview');
            Array.from(upload.files).forEach(function (file) {
                var isVideo = file.type.startsWith('video');
                var item = document.createElement('div');
                item.className = 'media-preview-item';
                item.innerHTML = isVideo
                    ? '<div class="media-preview-video"><i class="ri-video-line"></i><span>' + file.name + '</span></div>'
                    : '<img src="' + URL.createObjectURL(file) + '" class="media-preview-img" alt="preview">';
                var actions = document.createElement('div');
                actions.className = 'media-preview-actions';
                var input = document.createElement('input');
                input.className = 'form-control';
                input.style.fontSize = '0.8rem';
                input.style.padding = '4px 8px';
                input.placeholder = 'Caption (opsional)';
                var del = document.createElement('button');
                del.type = 'button';
                del.className = 'media-remove-btn';
                del.innerHTML = '<i class="ri-delete-bin-line"></i>';
                del.addEventListener('click', function () { item.remove(); });
                actions.appendChild(input);
                actions.appendChild(del);
                item.appendChild(actions);
                grid.appendChild(item);
            });
            upload.value = '';
        });
    }

    // modal
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
        // buka kembali modal log setelah gagal validasi
        document.getElementById('modalLog').style.display = 'flex';
    @endif
});
</script>
@endpush
