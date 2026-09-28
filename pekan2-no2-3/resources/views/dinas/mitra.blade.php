@extends('layouts.dashboard')

@section('title', 'Kelola Mitra | InkluSkill')

@section('content')
<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Mitra Industri</h1>
            <p class="page-subtitle">{{ count($mitra) }} mitra aktif</p>
        </div>
        <button type="button" class="btn btn-primary" data-open-modal="modalMitra">
            <i class="ri-add-line"></i> Tambah Mitra
        </button>
    </div>

    <div class="grid grid-2" style="gap:1.5rem">
        <div style="display:flex;flex-direction:column;gap:0.75rem">
            @foreach ($mitra as $m)
                <div class="card mitra-item" data-open-mitra="{{ $loop->index }}"
                    style="cursor:pointer;border:{{ $loop->first ? '2px solid var(--primary-color)' : '2px solid transparent' }}">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start">
                        <div>
                            <div style="font-weight:600">{{ $m['nama_perusahaan'] }}</div>
                            <div style="font-size:0.85rem;color:var(--text-light)">{{ $m['bidang_usaha'] }} &bull; {{ $m['kota_kabupaten'] }}</div>
                        </div>
                        <span class="badge badge-{{ $m['status'] === 'aktif' ? 'success' : 'warning' }}">{{ $m['status'] }}</span>
                    </div>
                    @if ($m['kontak_pic'])
                        <div style="font-size:0.8rem;margin-top:0.25rem"><i class="ri-user-line"></i> {{ $m['kontak_pic'] }} &bull; {{ $m['nomor_telepon'] }}</div>
                    @endif
                </div>
            @endforeach
        </div>

        <div>
            @foreach ($mitra as $m)
                <div class="card mitra-detail" data-mitra="{{ $loop->index }}" style="{{ $loop->first ? '' : 'display:none' }}">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem">
                        <div>
                            <h3>{{ $m['nama_perusahaan'] }}</h3>
                            <p style="color:var(--text-light)">{{ $m['bidang_usaha'] }} &bull; {{ $m['kota_kabupaten'] }}</p>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" data-open-modal="modalLowongan">
                            <i class="ri-add-line"></i> Tambah Lowongan
                        </button>
                    </div>

                    @if ($m['email'])
                        <p><i class="ri-mail-line"></i> {{ $m['email'] }}</p>
                    @endif
                    @if ($m['nomor_telepon'])
                        <p><i class="ri-phone-line"></i> {{ $m['nomor_telepon'] }}</p>
                    @endif

                    <h4 style="margin:1rem 0 0.75rem">Lowongan Tersedia</h4>
                    @if (count($m['lowongan']) === 0)
                        <p class="empty-state">Belum ada lowongan</p>
                    @else
                        <div style="display:flex;flex-direction:column;gap:0.5rem">
                            @foreach ($m['lowongan'] as $l)
                                <div style="padding:0.75rem;background:var(--bg-soft);border-radius:8px">
                                    <div style="display:flex;justify-content:space-between">
                                        <span style="font-weight:500">{{ $l['judul_posisi'] }}</span>
                                        <span class="badge badge-{{ $l['status'] === 'buka' ? 'success' : 'warning' }}">{{ $l['status'] }}</span>
                                    </div>
                                    <div style="font-size:0.8rem;color:var(--text-light);margin-top:0.25rem">
                                        {{ $l['nama_keterampilan'] }} &bull; {{ $l['jumlah_posisi'] }} posisi @if ($l['deadline']) &bull; Deadline: {{ $l['deadline'] }} @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- modal tambah mitra --}}
    <div class="modal-overlay" id="modalMitra" style="display:none">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3>Tambah Mitra Industri</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>
            <form onsubmit="return demoSimpanSubmit(event, 'modalMitra', 'Mitra industri berhasil ditambahkan (mode demo)')">
                @foreach ([['n' => 'nama_perusahaan', 'l' => 'Nama Perusahaan', 'r' => true], ['n' => 'bidang_usaha', 'l' => 'Bidang Usaha', 'r' => false], ['n' => 'kota_kabupaten', 'l' => 'Kota', 'r' => false], ['n' => 'kontak_pic', 'l' => 'Kontak PIC', 'r' => false], ['n' => 'nomor_telepon', 'l' => 'Nomor Telepon', 'r' => false], ['n' => 'email', 'l' => 'Email', 'r' => false]] as $f)
                    <div class="form-group">
                        <label>{{ $f['l'] }}</label>
                        <input class="form-control" name="{{ $f['n'] }}" {{ $f['r'] ? 'required' : '' }}>
                    </div>
                @endforeach
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- modal tambah lowongan --}}
    <div class="modal-overlay" id="modalLowongan" style="display:none">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 id="lowonganTitle">Tambah Lowongan</h3>
                <button type="button" data-close-modal><i class="ri-close-line"></i></button>
            </div>
            <form onsubmit="return demoSimpanSubmit(event, 'modalLowongan', 'Lowongan berhasil ditambahkan (mode demo)')">
                <div class="form-group">
                    <label>Judul Posisi</label>
                    <input class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Keterampilan</label>
                    <select class="form-control">
                        <option value="">-- Pilih --</option>
                        @foreach ($keterampilan as $k)
                            <option value="{{ $k['id_keterampilan'] }}">{{ $k['nama_keterampilan'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Posisi</label>
                    <input type="number" class="form-control" min="1" value="1">
                </div>
                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" class="form-control">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <div style="display:flex;gap:0.75rem">
                    <button type="button" class="btn btn-outline" data-close-modal>Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var items = document.querySelectorAll('.mitra-item');
    var details = document.querySelectorAll('.mitra-detail');

    items.forEach(function (item) {
        item.addEventListener('click', function () {
            items.forEach(function (i) {
                i.style.border = '2px solid transparent';
            });
            item.style.border = '2px solid var(--primary-color)';
            var idx = item.dataset.openMitra;
            details.forEach(function (d) { d.style.display = d.dataset.mitra === idx ? '' : 'none'; });
        });
    });

    document.querySelectorAll('[data-open-modal]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var modal = document.getElementById(btn.dataset.openModal);
            if (btn.dataset.openModal === 'modalLowongan') {
                var detail = btn.closest('.mitra-detail');
                var idx = detail ? detail.dataset.mitra : null;
                var nama = idx ? document.querySelector('.mitra-item[data-open-mitra="' + idx + '"] div div').textContent : '';
                document.getElementById('lowonganTitle').textContent = 'Tambah Lowongan — ' + nama;
            }
            modal.style.display = 'flex';
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

function demoSimpanSubmit(e, modalId, message) {
    e.preventDefault();
    document.getElementById(modalId).style.display = 'none';
    alert(message);
    return false;
}
</script>
@endpush
