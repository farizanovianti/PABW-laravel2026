<!DOCTYPE html>
<html lang="id">
@include('partials.head')
<body>
    <div style="display:flex;min-height:100vh">
        @include('partials.sidebar')
        <div style="flex:1;display:flex;flex-direction:column;background:#F5F7FB;overflow:hidden">
            @include('partials.dashboard-header')
            <main style="flex:1;padding:24px;overflow-y:auto">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
