@extends('layouts.app')

@section('title', 'Daftar | InkluSkill')

@section('content')
<div class="auth-page">
    <div class="auth-card" style="max-width:500px">
        <div class="auth-logo">
            <img src="{{ asset('assets/Logo Vector InkluSkill.png') }}" alt="InkluSkill" style="height:40px">
        </div>
        <h2 class="auth-title">Daftar Akun</h2>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        {{-- STEP 0: pilih role --}}
        <div id="regStepRole">
            <p class="auth-subtitle" style="margin-bottom:1.5rem">Saya mendaftar sebagai:</p>
            <div style="display:flex;flex-direction:column;gap:1rem">
                @foreach ([
                    ['value' => 'guru', 'label' => 'Guru SLB', 'desc' => 'Kelola data dan progress siswa ABK'],
                    ['value' => 'orang_tua', 'label' => 'Orang Tua / Wali', 'desc' => 'Pantau perkembangan anak dari rumah'],
                    ['value' => 'dinas', 'label' => 'Dinas / Instansi', 'desc' => 'Kelola penyaluran kerja ABK ke mitra'],
                ] as $r)
                    <button type="button" class="role-card" data-role="{{ $r['value'] }}">
                        <strong>{{ $r['label'] }}</strong>
                        <span>{{ $r['desc'] }}</span>
                    </button>
                @endforeach
            </div>
            <p class="auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>

        {{-- STEP 1: form data diri --}}
        <form id="regStepForm" method="POST" action="{{ route('register.attempt') }}" style="display:none">
            @csrf
            <input type="hidden" name="role" id="regRole" value="">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input name="nama_lengkap" class="form-control" placeholder="Nama lengkap"
                    value="{{ old('nama_lengkap') }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" class="form-control" placeholder="email@contoh.com"
                    value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" placeholder="Minimal 6 karakter"
                    required minlength="6">
            </div>
            <div class="form-group">
                <label>Nomor HP</label>
                <input name="nomor_hp" class="form-control" placeholder="08xx" value="{{ old('nomor_hp') }}">
            </div>

            {{-- khusus guru --}}
            <div class="reg-extra" data-role="guru" style="display:none">
                <div class="form-group">
                    <label>Sekolah</label>
                    <select name="nama_sekolah" class="form-control">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach ($sekolahList as $s)
                            <option value="{{ $s['nama_sekolah'] }}">
                                {{ $s['nama_sekolah'] }}@if(!empty($s['kecamatan'])) &ndash; {{ $s['kecamatan'] }}@endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kelas yang Diajar</label>
                    <input name="kelas_ajar" class="form-control" placeholder="contoh: Kelas X">
                </div>
            </div>

            {{-- khusus orang tua --}}
            <div class="reg-extra" data-role="orang_tua" style="display:none">
                <div class="form-group">
                    <label>Pilih Anak <span style="color:var(--danger)">*</span></label>
                    <select name="id_siswa" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach ($siswaList as $s)
                            <option value="{{ $s['id_siswa'] }}">
                                {{ $s['nama_lengkap'] }} - {{ $s['nama_sekolah'] }} &bull; {{ $s['kategori_disabilitas'] }} &bull; {{ $s['kelas'] }}
                            </option>
                        @endforeach
                    </select>
                    <small style="color:var(--gray);font-size:0.8rem;margin-top:4px;display:block">
                        Pilih anak yang terdaftar di sekolah SLB mitra.
                    </small>
                </div>
                <div class="form-group">
                    <label>Hubungan dengan ABK</label>
                    <select name="hubungan_abk" class="form-control">
                        <option value="orang_tua">Orang Tua</option>
                        <option value="wali">Wali</option>
                        <option value="saudara">Saudara</option>
                    </select>
                </div>
            </div>

            {{-- khusus dinas --}}
            <div class="reg-extra" data-role="dinas" style="display:none">
                <div class="form-group">
                    <label>NIP</label>
                    <input name="nip" class="form-control" placeholder="NIP (opsional)">
                </div>
                <div class="form-group">
                    <label>Unit Kerja</label>
                    <input name="unit_kerja" class="form-control" placeholder="Contoh: Dinas Sosial Kota Bandung">
                </div>
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem">
                <button type="button" id="regBackBtn" class="btn btn-outline" style="flex:1">Kembali</button>
                <button type="submit" class="btn btn-primary" style="flex:2">Daftar Sekarang</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var stepRole = document.getElementById('regStepRole');
    var stepForm = document.getElementById('regStepForm');
    var roleInput = document.getElementById('regRole');
    var backBtn = document.getElementById('regBackBtn');

    document.querySelectorAll('.role-card').forEach(function (card) {
        card.addEventListener('click', function () {
            var role = card.dataset.role;
            roleInput.value = role;
            stepRole.style.display = 'none';
            stepForm.style.display = 'block';
            document.querySelectorAll('.reg-extra').forEach(function (el) {
                el.style.display = el.dataset.role === role ? 'block' : 'none';
            });
        });
    });

    backBtn.addEventListener('click', function () {
        roleInput.value = '';
        stepForm.style.display = 'none';
        stepRole.style.display = 'block';
    });
});
</script>
@endpush
