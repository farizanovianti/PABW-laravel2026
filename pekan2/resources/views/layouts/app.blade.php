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

    <main class="container">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>