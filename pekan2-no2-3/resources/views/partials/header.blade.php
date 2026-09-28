@php($authUser = session('auth_user'))
@php($isTransparent = request()->routeIs('landing'))
<header class="main-header {{ $isTransparent ? 'transparent' : '' }}">
    <div class="header-inner">
        <a href="{{ route('landing') }}" class="brand">
            <img src="{{ asset('assets/Logo Vector InkluSkill.png') }}" alt="InkluSkill">
        </a>

        <nav class="navigation-items desktop-nav">
            <a href="{{ route('landing') }}" class="{{ $isTransparent ? 'active' : '' }}">Beranda</a>
            <button type="button" class="nav-scroll-btn" data-scroll="service">Pelatihan</button>
            <button type="button" class="nav-scroll-btn" data-scroll="workflow">Cara Kerja</button>

            @if (empty($authUser))
                <a href="{{ route('login') }}" class="nav-outline">Masuk</a>
                <a href="{{ route('register') }}" class="nav-login">Daftar</a>
            @else
                <a href="{{ $authUser['role'] === 'orang_tua' ? '/orangtua/dashboard' : '/'.$authUser['role'].'/dashboard' }}" class="nav-outline">
                    <i class="ri-dashboard-line"></i> Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="nav-login" style="cursor:pointer;border:none">
                        <i class="ri-logout-box-line"></i> Keluar
                    </button>
                </form>
            @endif
        </nav>

        <button type="button" class="mobile-menu-btn" aria-label="Buka menu" id="publicMenuBtn">
            <i class="ri-menu-line"></i>
        </button>
    </div>
</header>

<div class="mobile-drawer-backdrop" id="publicDrawerBackdrop"></div>

<aside class="public-drawer" id="publicDrawer">
    <div class="public-drawer-header">
        <a href="{{ route('landing') }}" class="brand">
            <img src="{{ asset('assets/Logo Vector InkluSkill.png') }}" alt="InkluSkill">
            <span class="brand-text">Inklu<span>Skill</span></span>
        </a>
        <button type="button" class="public-drawer-close" aria-label="Tutup menu" id="publicDrawerClose">
            <i class="ri-close-line"></i>
        </button>
    </div>

    @if (!empty($authUser))
        <div style="padding:1rem 1.25rem;background:var(--bg-soft);border-bottom:1px solid var(--border)">
            <div style="display:flex;align-items:center;gap:12px">
                <div class="user-avatar">
                    <i class="ri-user-line"></i>
                </div>
                <div>
                    <div style="font-weight:600;color:var(--text-dark)">{{ $authUser['name'] }}</div>
                    <span class="badge badge-active" style="margin-top:4px">
                        {{ strtoupper(str_replace('_', ' ', $authUser['role'])) }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    <nav class="public-drawer-nav">
        <a href="{{ route('landing') }}">
            <i class="ri-home-5-line"></i> Beranda
        </a>
        <button type="button" data-scroll="service">
            <i class="ri-book-open-line"></i> Pelatihan
        </button>
        <button type="button" data-scroll="workflow">
            <i class="ri-briefcase-line"></i> Cara Kerja
        </button>

        @if (!empty($authUser))
            <a href="{{ $authUser['role'] === 'orang_tua' ? '/orangtua/dashboard' : '/'.$authUser['role'].'/dashboard' }}">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
        @endif
    </nav>

    <div class="public-drawer-footer">
        @if (empty($authUser))
            <a href="{{ route('login') }}" class="btn btn-outline" style="width:100%;text-align:center;margin-bottom:10px">
                <i class="ri-login-box-line"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="btn btn-primary" style="width:100%;text-align:center">
                <i class="ri-user-add-line"></i> Daftar
            </a>
        @else
            <form action="{{ route('logout') }}" method="POST" style="width:100%">
                @csrf
                <button type="submit" class="btn btn-danger" style="width:100%">
                    <i class="ri-logout-box-line"></i> Keluar
                </button>
            </form>
        @endif
    </div>
</aside>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var drawer = document.getElementById('publicDrawer');
                var backdrop = document.getElementById('publicDrawerBackdrop');
                var openBtn = document.getElementById('publicMenuBtn');
                var closeBtn = document.getElementById('publicDrawerClose');

                function openDrawer() { drawer.classList.add('open'); backdrop.classList.add('show'); document.body.style.overflow = 'hidden'; }
                function closeDrawer() { drawer.classList.remove('open'); backdrop.classList.remove('show'); document.body.style.overflow = ''; }

                if (openBtn) openBtn.addEventListener('click', openDrawer);
                if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
                if (backdrop) backdrop.addEventListener('click', closeDrawer);

                document.querySelectorAll('[data-scroll]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        closeDrawer();
                        var goHome = btn.dataset.scroll && !document.getElementById(btn.dataset.scroll);
                        var scroll = function () {
                            var el = document.getElementById(btn.dataset.scroll);
                            if (el) el.scrollIntoView({ behavior: 'smooth' });
                        };
                        if (goHome) {
                            window.location.href = '{{ route('landing') }}#';
                            setTimeout(scroll, 300);
                        } else {
                            scroll();
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce
