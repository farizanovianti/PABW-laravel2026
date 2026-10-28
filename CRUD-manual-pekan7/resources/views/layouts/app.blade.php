<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'CRUD KONTAK')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/6.4.0/css/all.min.css"> 
</head>
<body>
    {{-- Navbar (menu bagian atas website) --}} 
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4"> 
        <div class="container"> 
            <a class="navbar-brand" href="{{ route('kontaks.index') }}">CRUD Kontak</a> 
            <ul class="navbar-nav ms-auto"> 
                <li class="nav-item"> 
                    <a class="nav-link" href="{{ route('kontaks.index') }}"> 
                        <i class="fas fa-address-book me-1"></i>Kontak 
                    </a> 
                </li> 
            </ul> 
        </div> 
    </nav>
    
    <div class="container"> 
        {{-- Pesan berhasil yang dikirim dari controller dengan with('success', ...) --}} 
        @if (session('success')) 
            <div class="alert alert-success alert-dismissible fade show" role="alert"> 
                {{ session('success') }} 
                <button type="button" class="btn-close" data-bs dismiss="alert" aria-label="Close"></button> 
            </div> 
        @endif 
  
        {{-- Ringkasan jika ada galat validasi --}} 
        @if ($errors->any()) 
            <div class="alert alert-danger"> 
                Data belum valid, periksa kembali isian form.
            </div> 
        @endif 
        @yield('content') 
    </div> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>