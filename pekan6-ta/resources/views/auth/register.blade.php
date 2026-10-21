@extends('layouts.app')

@section('title', 'Register Petugas')

@section('content')
<div class="card">
    <h2>Register Petugas</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <x-input name="name" label="Nama" />
        <x-input name="email" label="Email" type="email" />

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            @error('password')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn">Register</button>
    </form>
</div>
@endsection