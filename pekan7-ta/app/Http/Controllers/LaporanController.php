<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::latest()->paginate(5);
        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'lokasi' => 'required|string|max:255',
            'kecamatan' => ['required', Rule::in(Laporan::KECAMATAN)],
            'tinggi_air' => 'required|integer|min:1|max:1000',
            'keterangan' => 'nullable|string',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['foto'] = $request->file('foto')->store('foto_laporan', 'public');

        Laporan::create($validated);

        return redirect()->route('laporan.create')->with('success',
            'Laporan berhasil dikirim. Terima kasih, laporan Anda akan segera ditindaklanjuti petugas BPBD.');
    }

    public function show(Laporan $laporan)
    {
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'lokasi' => 'required|string|max:255',
            'kecamatan' => ['required', Rule::in(Laporan::KECAMATAN)],
            'tinggi_air' => 'required|integer|min:1|max:1000',
            'keterangan' => 'nullable|string',
            'status' => ['required', Rule::in(Laporan::STATUS)],
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($laporan->foto) {
                Storage::disk('public')->delete($laporan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_laporan', 'public');
        }

        $laporan->update($validated);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
