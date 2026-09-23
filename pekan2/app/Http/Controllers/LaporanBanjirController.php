<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanBanjirController extends Controller
{
    public function create(): View
    {
        return view('laporan-banjir.create');
    }

    public function store(Request $request): View
    {
        $laporan = $request->validate(
            [
                'nama_pelapor' => ['required', 'string', 'max:100'],
                'kecamatan' => ['required', 'string', 'max:100'],
                'desa' => ['required', 'string', 'max:100'],
                'tinggi_genangan' => ['required', 'integer', 'min:1', 'max:1000'],
            ],
            [],
            [
                'nama_pelapor' => 'nama pelapor',
                'tinggi_genangan' => 'tinggi genangan',
            ]
        );

        $status = $this->tentukanStatus((int) $laporan['tinggi_genangan']);

        return view('laporan-banjir.konfirmasi', compact('laporan', 'status'));
    }

    private function tentukanStatus(int $tinggiCm): string
    {
        return match (true) {
            $tinggiCm >= 150 => 'Bahaya',
            $tinggiCm >= 70  => 'Siaga',
            default => 'Waspada',
        };
    }
}