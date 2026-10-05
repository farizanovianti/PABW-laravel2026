<div class="laporan-card">
    <div class="laporan-card-header">
        <strong>{{ $laporan->nama_pelapor }}</strong>

        @isset($status)
            <span class="badge badge-{{ strtolower($status) }}">{{ $status }}</span>
        @endisset
    </div>

    <p>Kec. {{ $laporan->lokasi }}</p>
    <p>Tinggi genangan: <strong>{{ $laporan->tinggi_genangan }} cm</strong></p>
    <p>Tanggal kejadian: {{ $laporan->tanggal_kejadian->format('d-m-Y') }}</p>
</div>
