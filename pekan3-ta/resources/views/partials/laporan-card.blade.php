<div class="laporan-card">
    <div class="laporan-card-header">
        <strong>{{ $laporan['nama_pelapor'] }}</strong>

        @isset($status)
            <span class="badge badge-{{ strtolower($status) }}">{{ $status }}</span>
        @endisset
    </div>

    <p>Desa {{ $laporan['desa'] }}, Kec. {{ $laporan['kecamatan'] }}</p>
    <p>Tinggi genangan: <strong>{{ $laporan['tinggi_genangan'] }} cm</strong></p>
</div>