@extends('layouts.app')

@section('title', 'Masuk | InkluSkill')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <img src="{{ asset('assets/Logo Vector InkluSkill.png') }}" alt="InkluSkill" style="height:48px">
        </div>
        <h2 class="auth-title">Masuk ke InkluSkill</h2>
        <p class="auth-subtitle">Platform pelatihan vokasional untuk ABK</p>

        @if (session('registered'))
            <div class="alert alert-success">{{ session('registered') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="alert" style="background:#f0eff9;color:var(--primary-color);font-size:0.82rem;border:none;margin-bottom:1rem">
            <i class="ri-information-line"></i>
            Demo: <strong>guru@inkluskill.id</strong> / <strong>orangtua@inkluskill.id</strong> / <strong>dinas@inkluskill.id</strong> &mdash; password <strong>password</strong>
        </div>

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <div class="form-group">
                <label>Masuk sebagai</label>
                <div class="role-selector">
                    @foreach ([['value' => 'guru', 'label' => 'Guru SLB'], ['value' => 'orang_tua', 'label' => 'Orang Tua / Wali'], ['value' => 'dinas', 'label' => 'Dinas / Instansi']] as $r)
                        <label class="role-option {{ old('role', 'guru') === $r['value'] ? 'active' : '' }}">
                            <input type="radio" name="role" value="{{ $r['value'] }}"
                                {{ old('role', 'guru') === $r['value'] ? 'checked' : '' }}
                                style="display:none">
                            {{ $r['label'] }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control"
                    placeholder="email@contoh.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control"
                    placeholder="Minimal 6 karakter" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%">Masuk</button>
        </form>

        <p class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.role-option input').forEach(function (input) {
        input.addEventListener('change', function () {
            document.querySelectorAll('.role-option').forEach(function (el) { el.classList.remove('active'); });
            input.closest('.role-option').classList.add('active');
        });
    });
});
</script>
@endpush
