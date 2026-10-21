<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | LaporBanjir</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="header">
        <h1>LaporBanjir</h1>
        <p>BPBD Kabupaten Bandung</p>
    </header>

    <nav class="nav">
        <a href="{{ route('laporan-banjir.create') }}"
           class="{{ request()->routeIs('laporan-banjir.create') ? 'active' : '' }}">Buat Laporan</a>

        @auth
            <a href="{{ route('laporan-banjir.index') }}"
               class="{{ request()->routeIs('laporan-banjir.index') ? 'active' : '' }}">Daftar Laporan</a>
            <a href="{{ route('profil') }}"
               class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil Petugas</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-logout">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('register') }}"
               class="{{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
        @endauth
    </nav>

    <main class="container">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} BPBD Kabupaten Bandung &middot; LaporBanjir
    </footer>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
