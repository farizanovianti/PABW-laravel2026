@extends('layouts.dashboard')

@php($subTabs = ['Daftar Keterampilan', 'Kategori Disabilitas', 'Level Kompetensi', 'Daftar SLB'])
@php($health = [
    ['label' => 'Server Uptime', 'value' => 94, 'color' => '#10b981'],
    ['label' => 'Database Response', 'value' => 88, 'color' => '#524fa1'],
    ['label' => 'API Performance', 'value' => 72, 'color' => '#f59e0b'],
])
@php($logDot = ['error' => '#ef4444', 'warning' => '#f59e0b', 'info' => '#524fa1'])
@php($perPage = 5)
@php($maxSiswa = max(collect($keterampilan)->max('jumlah_siswa') ?: 0, 1))

@section('title', 'Master Data | InkluSkill')

@section('content')
<div>
    <div class="page-header" style="margin-bottom:1.5rem">
        <h1 class="page-title">Kelola Master Data &amp; Monitoring</h1>
        <div class="search-box" style="max-width:280px">
            <i class="ri-search-line"></i>
            <input type="text" id="masterSearch" placeholder="Cari data...">
        </div>
    </div>

    <div style="display:flex;border-bottom:2px solid var(--border);margin-bottom:1.5rem;gap:2rem">
        @foreach ([['key' => 'master', 'label' => 'Master Data'], ['key' => 'monitoring', 'label' => 'Log & Monitoring']] as $t)
            <button type="button" class="maintab-btn {{ $loop->first ? 'active' : '' }}" data-maintab="{{ $t['key'] }}">{{ $t['label'] }}</button>
        @endforeach
    </div>

    {{-- ==================== TAB MASTER ==================== --}}
    <div id="tabMaster">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;flex-wrap:wrap;gap:0.75rem">
            <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
                @foreach ($subTabs as $t)
                    <button type="button" class="subtab-btn {{ $loop->first ? 'active' : '' }}" data-subtab="{{ $t }}">{{ $t }}</button>
                @endforeach
            </div>
            <button type="button" class="btn btn-primary" data-open-modal="modalKeterampilan" id="btnTambahKeterampilan">
                <i class="ri-add-line"></i> Tambah Keterampilan
            </button>
        </div>

        {{-- daftar keterampilan --}}
        <div class="card subtab-panel" data-subtab="Daftar Keterampilan" style="padding:0;overflow:hidden">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:56px;padding-left:1.25rem">NO</th>
                        <th>NAMA KETERAMPILAN</th>
                        <th>KATEGORI</th>
                        <th>JUMLAH SISWA</th>
                        <th>STATUS</th>
                        <th style="text-align:right;padding-right:1.25rem">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keterampilan as $k)
                        @php($pct = (int) round(((int) ($k['jumlah_siswa'] ?: 0)) / $maxSiswa * 100))
                        <tr class="keterampilan-row" data-search="{{ strtolower($k['nama_keterampilan']) }}">
                            <td style="color:var(--text-light);font-weight:500;padding-left:1.25rem">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                            <td style="font-weight:600">{{ $k['nama_keterampilan'] }}</td>
                            <td>
                                <span style="padding:3px 12px;border-radius:999px;background:#ede9fe;color:#6d28d9;font-size:0.78rem;font-weight:600;letter-spacing:0.04em">
                                    {{ strtoupper($k['kategori'] ?: '-') }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div style="flex:1;max-width:110px;background:var(--extra-light);border-radius:99px;height:7px">
                                        <div style="width:{{ $pct }}%;background:var(--primary-color);height:100%;border-radius:99px"></div>
                                    </div>
                                    <span style="font-size:0.85rem;white-space:nowrap">{{ $k['jumlah_siswa'] ?: 0 }} siswa</span>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="toggle-status {{ $k['status'] === 'aktif' ? 'on' : '' }}" title="{{ $k['status'] === 'aktif' ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}">
                                    <span class="toggle-knob"></span>
                                </button>
                            </td>
                            <td style="text-align:right;padding-right:1.25rem">
                                <div style="display:flex;gap:4px;justify-content:flex-end">
                                    <button type="button" title="Edit" class="row-icon-btn" data-open-modal="modalKeterampilan" data-edit="{{ $k['nama_keterampilan'] }}">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button type="button" title="Hapus" class="row-icon-btn" data-delete="{{ $k['nama_keterampilan'] }}">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="empty-state">
                                <i class="ri-database-2-line" style="font-size:2.5rem;color:var(--extra-light)"></i>
                                <p>Belum ada keterampilan</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:0.875rem 1.25rem;border-top:1px solid var(--border)">
                <span style="font-size:0.83rem;color:var(--text-light)" id="masterCountInfo">Menampilkan {{ count($keterampilan) }} dari {{ count($keterampilan) }} keterampilan</span>
            </div>
        </div>

        {{-- daftar SLB --}}
        <div class="card subtab-panel" data-subtab="Daftar SLB" style="padding:0;overflow:hidden;display:none">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:56px;padding-left:1.25rem">NO</th>
                        <th>NAMA SEKOLAH</th>
                        <th>KOTA</th>
                        <th>SISWA</th>
                        <th>GURU</th>
                        <th>STATUS VERIFIKASI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sekolah as $s)
                        <tr>
                            <td style="color:var(--text-light);font-weight:500;padding-left:1.25rem">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                            <td style="font-weight:600">{{ $s['nama_sekolah'] }}</td>
                            <td>{{ $s['kota_kabupaten'] ?: '-' }}</td>
                            <td>{{ $s['jumlah_siswa'] ?: 0 }}</td>
                            <td>{{ $s['jumlah_guru'] ?: 0 }}</td>
                            <td>
                                <span class="badge badge-{{ $s['status_verifikasi'] === 'terverifikasi' ? 'success' : ($s['status_verifikasi'] === 'ditolak' ? 'danger' : 'warning') }}">
                                    {{ $s['status_verifikasi'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="empty-state">
                                <i class="ri-building-line" style="font-size:2.5rem;color:var(--extra-light)"></i>
                                <p>Belum ada data sekolah</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
            <div style="padding:0.875rem 1.25rem;border-top:1px solid var(--border)">
                <span style="font-size:0.83rem;color:var(--text-light)">Menampilkan {{ count($sekolah) }} sekolah</span>
            </div>
        </div>

        {{-- kategori disabilitas & level kompetensi --}}
        @foreach (['Kategori Disabilitas', 'Level Kompetensi'] as $tab)
            <div class="card subtab-panel" data-subtab="{{ $tab }}" style="display:none">
                <div class="empty-state">
                    <i class="ri-time-line" style="font-size:2.5rem;color:var(--extra-light)"></i>
                    <p>Segera hadir</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ==================== TAB MONITORING ==================== --}}
    <div id="tabMonitoring" style="display:none">
        <div style="display:grid;grid-template-columns:340px 1fr;gap:1.5rem;align-items:start">
            <div style="display:flex;flex-direction:column;gap:1rem">
                <div class="card">
                    <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;margin-bottom:1.25rem">SYSTEM HEALTH STATUS</div>
                    @foreach ($health as $h)
                        <div style="margin-bottom:1rem">
                            <div style="display:flex;justify-content:space-between;margin-bottom:5px">
                                <span style="font-size:0.88rem">{{ $h['label'] }}</span>
                                <span style="font-weight:700;color:{{ $h['color'] }}">{{ $h['value'] }}%</span>
                            </div>
                            <div style="background:var(--extra-light);border-radius:99px;height:8px">
                                <div style="width:{{ $h['value'] }}%;background:{{ $h['color'] }};height:100%;border-radius:99px"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card" style="border:1.5px solid #a7f3d0;background:#f0fdf9">
                    <div style="display:flex;gap:12px;margin-bottom:1rem">
                        <i class="ri-database-2-line" style="font-size:1.5rem;color:#10b981;margin-top:2px"></i>
                        <div>
                            <div style="font-weight:600;font-size:0.9rem">Backup terakhir: hari ini 07.30</div>
                            <div style="font-size:0.82rem;color:var(--text-light);margin-top:2px">Otomatisasi sistem berjalan normal.</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline" style="width:100%;text-align:center">Backup Manual Sekarang</button>
                </div>

                <div style="background:var(--primary-color);border-radius:14px;padding:1.25rem 1.5rem;color:#fff">
                    <div style="font-size:0.72rem;letter-spacing:0.1em;opacity:0.7;margin-bottom:4px">SYSTEM ENVIRONMENT</div>
                    <div style="font-size:1.4rem;font-weight:700">Production-v2</div>
                    <div style="display:flex;align-items:center;gap:6px;margin-top:8px;font-size:0.83rem;opacity:0.9">
                        <span style="width:8px;height:8px;border-radius:50%;background:#4ade80;display:inline-block"></span>
                        All modules running smoothly
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.625rem">
                    @foreach ([
                        ['icon' => 'ri-speed-line', 'label' => 'Network Latency', 'value' => '24ms', 'color' => '#10b981'],
                        ['icon' => 'ri-cpu-line', 'label' => 'Memory Usage', 'value' => '12.4 GB', 'sub' => '/32GB', 'color' => '#524fa1'],
                        ['icon' => 'ri-cloud-line', 'label' => 'Cloud Sync', 'value' => 'Synced', 'color' => '#f59e0b'],
                    ] as $m)
                        <div class="card" style="padding:0.875rem 0.5rem;text-align:center">
                            <div style="width:34px;height:34px;border-radius:9px;margin:0 auto 0.5rem;background:{{ $m['color'] }}18;display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:{{ $m['color'] }}">
                                <i class="{{ $m['icon'] }}"></i>
                            </div>
                            <div style="font-size:0.68rem;color:var(--text-light);margin-bottom:3px;line-height:1.3">{{ $m['label'] }}</div>
                            <div style="font-weight:700;font-size:0.88rem">
                                {{ $m['value'] }}@if (!empty($m['sub']))<span style="font-weight:400;font-size:0.72rem;color:var(--text-light)">{{ $m['sub'] }}</span>@endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card" style="padding:0;overflow:hidden">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem 1.25rem;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:0.5rem">
                    <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
                        @foreach (['semua', 'error', 'warning', 'info'] as $f)
                            <button type="button" class="logfilter-btn {{ $loop->first ? 'active' : '' }}" data-logfilter="{{ $f }}">{{ ucfirst($f) }}</button>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline btn-sm"><i class="ri-download-line"></i> Export Log</button>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:110px">STATUS WAKTU</th>
                            <th>PESAN LOG</th>
                            <th style="width:140px;text-align:right;padding-right:1.25rem">AKTOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logSistem as $l)
                            <tr class="log-row" data-level="{{ $l['level'] }}">
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <span class="log-dot" data-level="{{ $l['level'] }}"></span>
                                        <span style="font-size:0.82rem;font-family:monospace;color:var(--text-light)">{{ explode(' ', $l['created_at'])[1] ?? '--:--' }}</span>
                                    </div>
                                </td>
                                <td style="font-size:0.88rem">{{ $l['deskripsi'] }}</td>
                                <td style="text-align:right;padding-right:1.25rem">
                                    <span style="font-size:0.78rem;font-weight:600;padding:3px 10px;border-radius:999px;background:#f1f5f9;color:var(--text-dark)">{{ $l['aktor'] ?: 'SYSTEM' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3">
                                <div class="empty-state">
                                    <i class="ri-shield-check-line" style="font-size:2.5rem;color:var(--extra-light)"></i>
                                    <p>Tidak ada log sistem</p>
                                </div>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="padding:0.875rem 1.25rem;border-top:1px solid var(--border)">
                    <span style="font-size:0.83rem;color:var(--text-light)" id="logCountInfo">Menampilkan {{ count($logSistem) }} dari {{ count($logSistem) }} log sistem terdeteksi.</span>
                </div>
            </div>
        </div>
    </div>

    {{-- modal keterampilan --}}
    <div class="modal-overlay" id="modalKeterampilan" style="display:none">
        <div class="modal-card">
            <div class="modal-header">
                <h3 id="modalKetTitle">Tambah Keterampilan</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>
            <form onsubmit="return demoKetSubmit(event)">
                <div class="form-group">
                    <label>Nama Keterampilan <span style="color:var(--danger)">*</span></label>
                    <input class="form-control" id="ketNama" placeholder="Contoh: Menjahit" required>
                </div>
                <div class="form-group">
                    <label>Kategori <span style="color:var(--danger)">*</span></label>
                    <select class="form-control" id="ketKategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach (['Tata Busana', 'Kuliner', 'Industri Kreatif', 'Seni Kriya', 'Agribisnis', 'Jasa', 'Teknologi'] as $c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" rows="3" placeholder="Deskripsi singkat keterampilan..."></textarea>
                </div>
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" style="flex:1" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary" style="flex:2" id="modalKetSubmit">Tambah Keterampilan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .maintab-btn {
        background: none; border: none; padding: 0.6rem 0;
        font-weight: 600; font-size: 0.95rem; cursor: pointer;
        color: var(--text-light);
        border-bottom: 2px solid transparent;
        margin-bottom: -2px; transition: 0.2s;
    }
    .maintab-btn.active { color: var(--primary-color); border-bottom-color: var(--primary-color); }
    .subtab-btn {
        padding: 6px 18px; border-radius: 999px; border: 1.5px solid;
        font-weight: 500; font-size: 0.875rem; cursor: pointer;
        background: #fff; color: var(--text-dark); border-color: var(--border);
        transition: 0.2s;
    }
    .subtab-btn.active { background: var(--primary-color); color: #fff; border-color: var(--primary-color); }
    .logfilter-btn {
        padding: 5px 14px; border-radius: 999px; border: 1.5px solid;
        font-weight: 500; font-size: 0.82rem; cursor: pointer;
        background: #fff; color: var(--text-dark); border-color: var(--border);
        text-transform: capitalize;
    }
    .logfilter-btn.active { background: var(--primary-color); color: #fff; border-color: var(--primary-color); }
    .row-icon-btn {
        background: none; border: none; cursor: pointer; color: var(--text-light);
        font-size: 1.1rem; padding: 4px 6px; border-radius: 6px;
    }
    .toggle-status {
        width: 40px; height: 22px; border-radius: 99px; position: relative;
        cursor: pointer; background: #d1d5db; transition: 0.3s; border: none;
    }
    .toggle-status.on { background: var(--primary-color); }
    .toggle-knob {
        position: absolute; top: 3px; left: 3px; width: 16px; height: 16px;
        border-radius: 50%; background: #fff; transition: 0.3s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.25);
    }
    .toggle-status.on .toggle-knob { left: 21px; }
    .log-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; box-sizing: border-box; }
    .log-dot[data-level="error"] { background: #ef4444; }
    .log-dot[data-level="warning"] { background: #f59e0b; }
    .log-dot[data-level="info"] { background: transparent; border: 2px solid #524fa1; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // main tabs
    document.querySelectorAll('.maintab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.maintab-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            document.getElementById('tabMaster').style.display = btn.dataset.maintab === 'master' ? '' : 'none';
            document.getElementById('tabMonitoring').style.display = btn.dataset.maintab === 'monitoring' ? '' : 'none';
            document.getElementById('btnTambahKeterampilan').style.display = btn.dataset.maintab === 'master' ? '' : 'none';
        });
    });

    // sub tabs
    document.querySelectorAll('.subtab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.subtab-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            document.querySelectorAll('.subtab-panel').forEach(function (p) {
                p.style.display = p.dataset.subtab === btn.dataset.subtab ? '' : 'none';
            });
        });
    });

    // search keterampilan
    var search = document.getElementById('masterSearch');
    search.addEventListener('input', function () {
        var q = search.value.toLowerCase();
        var visible = 0;
        document.querySelectorAll('.keterampilan-row').forEach(function (row) {
            var match = row.dataset.search.indexOf(q) !== -1;
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        document.getElementById('masterCountInfo').textContent = 'Menampilkan ' + visible + ' dari ' + {{ count($keterampilan) }} + ' keterampilan';
    });

    // log filter
    document.querySelectorAll('.logfilter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.logfilter-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var f = btn.dataset.logfilter;
            var visible = 0;
            document.querySelectorAll('.log-row').forEach(function (row) {
                var match = f === 'semua' || row.dataset.level === f;
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            document.getElementById('logCountInfo').textContent = 'Menampilkan ' + visible + ' dari ' + {{ count($logSistem) }} + ' log sistem terdeteksi.';
        });
    });

    // toggle status
    document.querySelectorAll('.toggle-status').forEach(function (t) {
        t.addEventListener('click', function () {
            t.classList.toggle('on');
        });
    });

    // delete keterampilan (demo)
    document.querySelectorAll('[data-delete]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (window.confirm('Hapus keterampilan ini? Data terkait (log aktivitas, modul) juga akan dihapus.')) {
                alert('Keterampilan "' + btn.dataset.delete + '" dihapus (mode demo)');
                location.reload();
            }
        });
    });

    // modal keterampilan (tambah/edit)
    document.querySelectorAll('[data-open-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var isEdit = btn.dataset.edit !== undefined;
            document.getElementById('modalKetTitle').textContent = isEdit ? 'Edit Keterampilan' : 'Tambah Keterampilan';
            document.getElementById('modalKetSubmit').textContent = isEdit ? 'Simpan Perubahan' : 'Tambah Keterampilan';
            document.getElementById('ketNama').value = isEdit ? btn.dataset.edit : '';
            document.getElementById('modalKeterampilan').style.display = 'flex';
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
});

function demoKetSubmit(e) {
    e.preventDefault();
    document.getElementById('modalKeterampilan').style.display = 'none';
    alert('Data keterampilan tersimpan (mode demo)');
    location.reload();
    return false;
}
</script>
@endpush
