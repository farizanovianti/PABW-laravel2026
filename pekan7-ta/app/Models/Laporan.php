<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';

    protected $fillable = [
        'nama_pelapor',
        'no_hp',
        'lokasi',
        'kecamatan',
        'tinggi_air',
        'keterangan',
        'foto',
        'status',
    ];

    public const KECAMATAN = [
        'Baleendah', 'Banjaran', 'Bojongsoang', 'Ciparay', 'Dayeuhkolot',
        'Katapang', 'Majalaya', 'Margahayu', 'Rancaekek', 'Solokanjeruk',
    ];

    public const STATUS = ['Menunggu', 'Diproses', 'Selesai'];
}
