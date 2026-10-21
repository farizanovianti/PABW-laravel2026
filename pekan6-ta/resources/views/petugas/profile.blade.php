@extends('layouts.app')

@section('title', 'Profil Petugas')

@section('content')
<div class="card">
    <h2>Profil Petugas</h2>

    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    <p><strong>Akun dibuat:</strong>
        {{ Auth::user()->created_at->format('d-m-Y H:i') }}
        ({{ Auth::user()->created_at->diffForHumans() }})
    </p>
</div>
@endsection