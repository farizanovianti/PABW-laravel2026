<?php

namespace App\Http\Controllers;
use App\Models\Laporan;
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
        $validated = $request->validate(
            [
                'nama_pelapor' => ['required', 'string', 'max:100'],
                'lokasi' => ['required', 'string', 'max:150'],
                'tinggi_genangan' => ['required', 'integer', 'min:1', 'max:1000'],
                'tanggal_kejadian' => ['required', 'date', 'before_or_equal:today'],
            ],
            [],
            [
                'nama_pelapor' => 'nama pelapor',
                'tinggi_genangan' => 'tinggi genangan',
                'tanggal_kejadian' => 'tanggal kejadian',
            ]
        );

        $laporan = Laporan::create($validated);

        return redirect()
            ->route('laporan-banjir.konfirmasi')
            ->with('laporan_id', $laporan->id);
    }

    public function konfirmasi(): View|RedirectResponse
    {
        $laporan = Laporan::find(session('laporan_id'));

        if (! $laporan) {
            return redirect()->route('laporan-banjir.create');
        }

        return view('laporan-banjir.konfirmasi', compact('laporan'));
    }

    public function index(): View
    {
        $daftarLaporan = Laporan::all()->sortByDesc('tanggal_kejadian');

        return view('laporan-banjir.index', compact('daftarLaporan'));
    }
}
