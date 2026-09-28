@php($authUser = session('auth_user'))
@php($menu = [
    'guru' => [
        ['route' => 'guru.dashboard', 'exact' => true, 'icon' => 'ri-dashboard-line', 'label' => 'Dashboard'],
        ['route' => 'guru.siswa.index', 'exact' => false, 'icon' => 'ri-group-line', 'label' => 'Daftar Siswa'],
        ['route' => 'guru.validasi', 'exact' => true, 'icon' => 'ri-shield-check-line', 'label' => 'Validasi Kompetensi'],
        ['route' => 'guru.modul', 'exact' => true, 'icon' => 'ri-book-open-line', 'label' => 'Modul Ajar'],
        ['route' => 'guru.pengajuan', 'exact' => true, 'icon' => 'ri-send-plane-line', 'label' => 'Laporan & Pengajuan'],
    ],
    'dinas' => [
        ['route' => 'dinas.dashboard', 'exact' => true, 'icon' => 'ri-dashboard-line', 'label' => 'Dashboard'],
        ['route' => 'dinas.siswa.index', 'exact' => false, 'icon' => 'ri-group-line', 'label' => 'Database ABK'],
        ['route' => 'dinas.pengajuan', 'exact' => true, 'icon' => 'ri-inbox-line', 'label' => 'Pengajuan Masuk'],
        ['route' => 'dinas.pipeline', 'exact' => true, 'icon' => 'ri-flow-chart', 'label' => 'Matching & Pipeline'],
        ['route' => 'dinas.mitra', 'exact' => true, 'icon' => 'ri-building-line', 'label' => 'Kelola Mitra'],
        ['route' => 'dinas.master', 'exact' => true, 'icon' => 'ri-settings-3-line', 'label' => 'Master Data'],
    ],
])
@php($items = $menu[$authUser['role']] ?? [])
@php($roleLabel = ['guru' => 'Guru', 'orang_tua' => 'Orang Tua', 'dinas' => 'Dinas Pendidikan'][$authUser['role']] ?? $authUser['role'])
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-inner">
            <img src="{{ asset('assets/Logo Vector InkluSkill.png') }}" alt="InkluSkill">
        </div>
    </div>

    <nav>
        @foreach ($items as $it)
            @php($active = request()->routeIs($it['route']) && ($it['exact'] ? !request()->route(request()->route()->parameterNames()[0] ?? null) || $it['exact'] : true))
            @if ($it['exact'])
                @php($active = request()->routeIs($it['route']))
            @else
                @php($active = request()->routeIs($it['route']) && !request()->route('id'))
            @endif
            <a href="{{ route($it['route']) }}" class="nav-link {{ $active ? 'active' : '' }}">
                <i class="{{ $it['icon'] }}"></i>
                <span>{{ $it['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="sidebar-profile">
        <div class="sidebar-profile-card">
            <div class="sidebar-profile-avatar">
                {{ mb_strtoupper(mb_substr($authUser['name'], 0, 1)) }}
            </div>
            <div class="sidebar-profile-text">
                <div class="sidebar-profile-name">{{ $authUser['name'] }}</div>
                <div class="sidebar-profile-role">{{ $roleLabel }}</div>
            </div>
        </div>
    </div>

    <div class="sidebar-logout-section">
        <form action="{{ route('logout') }}" method="POST" style="width:100%">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <i class="ri-logout-box-line"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
