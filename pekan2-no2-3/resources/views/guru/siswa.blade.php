@extends('layouts.dashboard')

@php($oldMode = old('mode'))

@section('title', 'Daftar Siswa | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Daftar Siswa</h1>
            <p class="page-subtitle">{{ count($siswa) }} siswa terdaftar di kelas Anda</p>
        </div>
        <button type="button" class="btn btn-primary" data-open-tambah>
            <i class="ri-user-add-line"></i> Tambah Siswa
        </button>
    </div>

    <div class="card">
        <div class="card-toolbar">
            <div class="search-box">
                <i class="ri-search-line"></i>
                <input type="text" id="siswaSearch" placeholder="Cari nama atau disabilitas...">
            </div>
        </div>

        @if (count($siswa) === 0)
            <div class="empty-state">
                <i class="ri-group-line" style="font-size:3rem;color:var(--extra-light)"></i>
                <p>Belum ada siswa</p>
            </div>
        @else
            <div class="table-wrapper">
                <table class="data-table" id="siswaTable">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Disabilitas</th>
                            <th>Sekolah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $s)
                            <tr class="siswa-row"
                                data-search="{{ strtolower($s['nama_lengkap'].' '.$s['kategori_disabilitas']) }}">
                                <td>
                                    <div class="student-name">
                                        <div class="avatar-sm">{{ mb_substr($s['nama_lengkap'] ?: '?', 0, 1) }}</div>
                                        <span>{{ $s['nama_lengkap'] }}</span>
                                    </div>
                                </td>
                                <td>{{ $s['kelas'] ?: '-' }}</td>
                                <td><span class="badge badge-info">{{ $s['kategori_disabilitas'] ?: '-' }}</span></td>
                                <td>{{ $s['nama_sekolah'] ?: '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $s['status'] === 'aktif' ? 'success' : 'warning' }}">
                                        {{ $s['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
                                        <a href="{{ route('guru.siswa.show', $s['id_siswa']) }}" class="btn btn-sm btn-outline">
                                            <i class="ri-eye-line"></i> Detail
                                        </a>
                                        <button type="button" class="btn btn-sm" style="background:#eff6ff;color:#1d4ed8"
                                            data-open-edit="{{ $s['id_siswa'] }}"
                                            data-nama="{{ $s['nama_lengkap'] }}"
                                            data-tanggal="{{ $s['tanggal_lahir'] }}"
                                            data-jk="{{ $s['jenis_kelamin'] }}"
                                            data-disabilitas="{{ $s['kategori_disabilitas'] }}"
                                            data-kelas="{{ $s['kelas'] }}"
                                            data-status="{{ $s['status'] }}">
                                            <i class="ri-edit-line"></i> Edit
                                        </button>
                                        <form action="{{ route('guru.siswa.destroy', $s['id_siswa']) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data siswa {{ $s['nama_lengkap'] }}? Tindakan ini tidak bisa dibatalkan.')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm" style="background:#fef2f2;color:#dc2626">
                                                <i class="ri-delete-bin-line"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ============ modal TAMBAH siswa (input -> proses store -> output daftar) ============ --}}
    <div class="modal-overlay" id="modalTambah" style="display:none">
        <div class="modal-card" style="max-width:540px">
            <div class="modal-header">
                <h3>Tambah Siswa Baru</h3>
                <button type="button" data-close-modal aria-label="Tutup"><i class="ri-close-line"></i></button>
            </div>

            @if ($errors->any() && $oldMode === 'tambah')
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('guru.siswa.store') }}">
                @csrf
                <input type="hidden" name="mode" value="tambah">
                <div class="form-group">
                    <label>Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input name="nama_lengkap" class="form-control" placeholder="Nama lengkap siswa"
                        value="{{ old('nama_lengkap') }}" required>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input name="tanggal_lahir" type="date" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="L" {{ old('jenis_kelamin', 'L') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem">
                    <div class="form-group">
                        <label>Kategori Disabilitas <span style="color:var(--danger)">*</span></label>
                        <select name="kategori_disabilitas" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($disabilitas as $d)
                                <option value="{{ $d['nama'] }}" {{ old('kategori_disabilitas') === $d['nama'] ? 'selected' : '' }}>
                                    {{ $d['nama'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input name="kelas" class="form-control" placeholder="Contoh: X-A" value="{{ old('kelas') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Orang Tua / Wali</label>
                    <input name="nama_orangtua" class="form-control" placeholder="Nama orang tua/wali" value="{{ old('nama_orangtua') }}">
                </div>

                <div class="form-group">
                    <label>Kontak Orang Tua</label>
                    <input name="kontak_orangtua" class="form-control" placeholder="08xx" value="{{ old('kontak_orangtua') }}">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div style="display:flex;gap:0.75rem;margin-top:0.5rem">
                    <button type="button" class="btn btn-outline" style="flex:1" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary" style="flex:2">Tambah Siswa</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ modal EDIT siswa ============ --}}
    <div class="modal-overlay" id="modalEdit" style="display:none">
        <div class="modal-card" style="max-width:540px">
            <div class="modal-header">
                <h3 id="editTitle">Edit Data Siswa</h3>
                <button type="button" data-close-modal aria-label="Tutup"><i class="ri-close-line"></i></button>
            </div>

            @if ($errors->any() && $oldMode === 'edit')
                <div class="alert alert-danger" style="margin-bottom:1rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="" id="editForm">
                @csrf
                <input type="hidden" name="mode" value="edit">
                <input type="hidden" name="id_siswa" id="editId" value="{{ old('id_siswa') }}">

                <div class="form-group">
                    <label>Nama Lengkap <span style="color:var(--danger)">*</span></label>
                    <input name="nama_lengkap" id="editNama" class="form-control"
                        value="{{ $oldMode === 'edit' ? old('nama_lengkap') : '' }}" required>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input name="tanggal_lahir" type="date" id="editTanggal" class="form-control"
                            value="{{ $oldMode === 'edit' ? old('tanggal_lahir') : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="editJk" class="form-control">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem">
                    <div class="form-group">
                        <label>Kategori Disabilitas <span style="color:var(--danger)">*</span></label>
                        <select name="kategori_disabilitas" id="editDisabilitas" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($disabilitas as $d)
                                <option value="{{ $d['nama'] }}">{{ $d['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input name="kelas" id="editKelas" class="form-control"
                            value="{{ $oldMode === 'edit' ? old('kelas') : '' }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="editStatus" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div style="display:flex;gap:0.75rem;margin-top:0.5rem">
                    <button type="button" class="btn btn-outline" style="flex:1" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary" style="flex:2">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // search filter
    var search = document.getElementById('siswaSearch');
    if (search) {
        search.addEventListener('input', function () {
            var q = search.value.toLowerCase();
            document.querySelectorAll('.siswa-row').forEach(function (row) {
                row.style.display = row.dataset.search.indexOf(q) !== -1 ? '' : 'none';
            });
        });
    }

    var modalTambah = document.getElementById('modalTambah');
    var modalEdit = document.getElementById('modalEdit');

    document.querySelectorAll('[data-open-tambah]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            modalTambah.style.display = 'flex';
        });
    });

    function fillEditForm(btn) {
        document.getElementById('editForm').action = @json(url('guru/siswa')) + '/' + btn.dataset.openEdit;
        document.getElementById('editId').value = btn.dataset.openEdit;
        document.getElementById('editTitle').textContent = 'Edit Data Siswa: ' + btn.dataset.nama;
        document.getElementById('editNama').value = btn.dataset.nama;
        document.getElementById('editTanggal').value = btn.dataset.tanggal || '';
        document.getElementById('editJk').value = btn.dataset.jk || 'L';
        document.getElementById('editDisabilitas').value = btn.dataset.disabilitas || '';
        document.getElementById('editKelas').value = btn.dataset.kelas || '';
        document.getElementById('editStatus').value = btn.dataset.status || 'aktif';
    }

    document.querySelectorAll('[data-open-edit]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            fillEditForm(btn);
            modalEdit.style.display = 'flex';
        });
    });

    @if ($oldMode === 'edit')
        // setelah gagal validasi edit: buka kembali modal edit dengan old values
        var editBtn = document.querySelector('[data-open-edit="{{ old('id_siswa') }}"]');
        if (editBtn) {
            modalEdit.style.display = 'flex';
            @if (! $errors->any())
                fillEditForm(editBtn);
            @endif
            document.getElementById('editStatus').value = {{ json_encode(old('status', 'aktif')) }};
            document.getElementById('editJk').value = {{ json_encode(old('jenis_kelamin', 'L')) }};
            var dis = document.getElementById('editDisabilitas');
            var oldDis = {{ json_encode(old('kategori_disabilitas')) }};
            if (oldDis) dis.value = oldDis;
        }
    @elseif ($oldMode === 'tambah')
        modalTambah.style.display = 'flex';
    @endif

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
</script>
@endpush
