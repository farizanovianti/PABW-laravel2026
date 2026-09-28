@php($titles = [
    'guru.dashboard' => 'Dashboard',
    'guru.siswa.index' => 'Daftar Siswa',
    'guru.siswa.show' => 'Profil Siswa',
    'guru.validasi' => 'Validasi Kompetensi',
    'guru.modul' => 'Modul Ajar',
    'guru.pengajuan' => 'Laporan & Pengajuan',
    'dinas.dashboard' => 'Dashboard',
    'dinas.siswa.index' => 'Database ABK',
    'dinas.siswa.show' => 'Profil ABK',
    'dinas.pengajuan' => 'Pengajuan Masuk',
    'dinas.pipeline' => 'Matching & Pipeline',
    'dinas.mitra' => 'Kelola Mitra',
    'dinas.master' => 'Master Data',
])
@php($authUser = session('auth_user'))
@php($pageTitle = collect($titles)->first(fn ($t, $r) => request()->routeIs($r)) ?? 'InkluSkill')
<header class="dash-header">
    <h1 class="dash-header-title">{{ $pageTitle }}</h1>
    <div class="dash-header-right">
        <div class="dash-search">
            <i class="ri-search-line"></i>
            <input type="text" placeholder="Cari siswa atau modul...">
        </div>
        <div class="dash-avatar" title="{{ $authUser['name'] ?? '' }}">
            {{ mb_strtoupper(mb_substr($authUser['name'] ?? 'U', 0, 1)) }}
        </div>
    </div>
</header>

<style>
    .dash-header {
        height: 56px; background: #fff; border-bottom: 1px solid #E5E5E5;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 24px; flex-shrink: 0; position: sticky; top: 0; z-index: 50;
    }
    .dash-header-title { font-size: 1.25rem; font-weight: 600; color: #171717; margin: 0; }
    .dash-header-right { display: flex; align-items: center; gap: 16px; }
    .dash-search {
        display: flex; align-items: center; gap: 8px;
        background: #F5F7FB; border: 1px solid #E5E5E5;
        border-radius: 8px; padding: 0 12px; height: 38px; width: 256px;
    }
    .dash-search i { color: #A3A3A3; font-size: 0.875rem; flex-shrink: 0; }
    .dash-search input {
        border: none; background: none; outline: none;
        font-size: 0.8125rem; color: #374151; width: 100%; font-family: inherit;
    }
    .dash-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--primary-color); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.75rem; cursor: pointer; flex-shrink: 0;
    }
</style>
