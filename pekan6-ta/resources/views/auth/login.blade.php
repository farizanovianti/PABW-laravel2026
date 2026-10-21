@extends('layouts.app')

@section('title', 'Login Petugas')

@section('content')
<div class="card">
    <h2>Login Petugas</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <x-input name="email" label="Email" type="email" />

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            @error('password')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-check">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember Me</label>
        </div>

        <button type="submit" class="btn">Login</button>
    </form>
</div>
@endsection