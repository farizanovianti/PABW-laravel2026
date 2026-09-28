<!DOCTYPE html>
<html lang="id">
@include('partials.head')
<body>
@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var drawer = document.getElementById('mobileDrawer');
                var overlay = document.getElementById('mobileDrawerOverlay');
                var openBtn = document.getElementById('mobileDrawerBtn');
                var closeBtn = document.getElementById('mobileDrawerClose');

                function openDrawer() { drawer.classList.add('open'); overlay.style.display = 'block'; }
                function closeDrawer() { drawer.classList.remove('open'); overlay.style.display = 'none'; }

                if (openBtn) openBtn.addEventListener('click', openDrawer);
                if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
                if (overlay) overlay.addEventListener('click', closeDrawer);
            });
        </script>
    @endpush
@endonce

@php($authUser = session('auth_user'))
@php($items = [
    ['route' => 'orangtua.dashboard', 'icon' => 'ri-home-5-line', 'iconActive' => 'ri-home-5-fill', 'label' => 'Beranda', 'title' => 'Beranda'],
    ['route' => 'orangtua.anak', 'icon' => 'ri-user-heart-line', 'iconActive' => 'ri-user-heart-fill', 'label' => 'Profil Anak', 'title' => 'Profil Anak'],
    ['route' => 'orangtua.jalur', 'icon' => 'ri-route-line', 'iconActive' => 'ri-route-fill', 'label' => 'Jalur', 'title' => 'Jalur Kemandirian'],
    ['route' => 'orangtua.modul', 'icon' => 'ri-book-2-line', 'iconActive' => 'ri-book-2-fill', 'label' => 'Panduan', 'title' => 'Panduan Latihan'],
])
@php($pageTitle = collect($items)->first(fn ($i) => request()->routeIs($i['route']))['title'] ?? 'InkluSkill')
<div class="mobile-app">
    <header class="mobile-header">
        <div class="mobile-header-left">
            <img src="{{ asset('assets/Logo Vector InkluSkill.png') }}" alt="InkluSkill" class="mobile-logo">
        </div>
        <div class="mobile-header-title">{{ $pageTitle }}</div>
        <button type="button" class="mobile-hamburger" id="mobileDrawerBtn" aria-label="Menu">
            <i class="ri-menu-line"></i>
        </button>
    </header>

    <div class="mobile-drawer-overlay" id="mobileDrawerOverlay" style="display:none;z-index:200"></div>

    <div class="mobile-drawer" id="mobileDrawer" style="z-index:300">
        <div class="mobile-drawer-header">
            <div class="mobile-drawer-user">
                <div class="mobile-drawer-avatar">
                    {{ mb_strtoupper(mb_substr($authUser['name'] ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="mobile-drawer-name">{{ $authUser['name'] ?? '' }}</div>
                    <div class="mobile-drawer-role">Orang Tua / Wali</div>
                </div>
            </div>
            <button type="button" class="mobile-drawer-close" id="mobileDrawerClose">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <nav class="mobile-drawer-nav">
            @foreach ($items as $it)
                <a href="{{ route($it['route']) }}" class="mobile-drawer-link {{ request()->routeIs($it['route']) ? 'active' : '' }}">
                    <i class="{{ $it['icon'] }}"></i>
                    <span>{{ $it['title'] }}</span>
                </a>
            @endforeach
        </nav>

        <form action="{{ route('logout') }}" method="POST" style="padding:1rem 1.25rem;border-top:1px solid var(--border)">
            @csrf
            <button type="submit" class="mobile-drawer-logout" style="width:100%">
                <i class="ri-logout-box-line"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>

    <main class="mobile-main" style="padding-bottom:1rem">
        @include('partials.flash')
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
