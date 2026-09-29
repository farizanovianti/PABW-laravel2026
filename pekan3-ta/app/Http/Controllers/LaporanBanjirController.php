<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanBanjirController extends Controller
{
    public function create(): View
    {
        return view('laporan-banjir.create');
    }

    public function store(Request $request): RedirectResponse
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

        $request->session()->push('laporan_baru', $laporan);

        return redirect()
            ->route('laporan-banjir.konfirmasi')
            ->with('laporan', $laporan);
    }

    public function konfirmasi(): View|RedirectResponse
    {
        $laporan = session('laporan');

        if (! $laporan) {
            return redirect()->route('laporan-banjir.create');
        }

        return view('laporan-banjir.konfirmasi', compact('laporan'));
    }

    public function index(): View
    {
        $daftarLaporan = array_merge(
            array_reverse(session('laporan_baru', [])),
            $this->laporanContoh()
        );

        return view('laporan-banjir.index', compact('daftarLaporan'));
    }

    private function laporanContoh(): array
    {
        return [
            ['nama_pelapor' => 'Budiman', 'kecamatan' => 'Baleendah', 'desa' => 'Andir', 'tinggi_genangan' => 25],
            ['nama_pelapor' => 'Siti Aminah', 'kecamatan' => 'Dayeuhkolot', 'desa' => 'Citeureup', 'tinggi_genangan' => 45],
            ['nama_pelapor' => 'Asep Hidayat', 'kecamatan' => 'Bojongsoang', 'desa' => 'Bojongsari', 'tinggi_genangan' => 70],
            ['nama_pelapor' => 'Ayu Ting Ting', 'kecamatan' => 'Baleendah', 'desa' => 'Rancamanyar', 'tinggi_genangan' => 110],
            ['nama_pelapor' => 'Kim Seok-Jin', 'kecamatan' => 'Rancaekek', 'desa' => 'Bojongloa', 'tinggi_genangan' => 30],
        ];
    }
}