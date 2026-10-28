<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kontak;
use Illuminate\Support\Facades\Storage;
class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontaks = Kontak::latest()->paginate(5);
        return view('kontaks.index', compact('kontaks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kontaks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'nama'   => 'required|string|max:255', 
            'alamat' => 'required|string', 
            'no_hp'  => 'required|string|max:15', 
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ]);

        if ($request->hasFile('foto')) { 
            $validated['foto'] = $request->file('foto')->store('foto_kontak', 'public'); 
        } 
  
        Kontak::create($validated); 
  
        return redirect()->route('kontaks.index')->with('success', 'Kontak berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontak $kontak)
    {
         return view('kontaks.show', compact('kontak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontak $kontak)
    {
        return view('kontaks.edit', compact('kontak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontak $kontak)
    {
        $validated = $request->validate([ 
            'nama'   => 'required|string|max:255', 
            'alamat' => 'required|string', 
            'no_hp'  => 'required|string|max:15', 
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        ]); 
  
        if ($request->hasFile('foto')) { 
            if ($kontak->foto) { 
                Storage::disk('public')->delete($kontak->foto);  
            } 
            $validated['foto'] = $request->file('foto')->store('foto_kontak', 'public'); 
        } 
  
        $kontak->update($validated); 
  
        return redirect()->route('kontaks.index')->with('success', 'Kontak berhasil diperbarui.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontak $kontak)
    {
        if ($kontak->foto) { 
            Storage::disk('public')->delete($kontak->foto);
        } 
        $kontak->delete(); // Hapus data dari database 
  
        return redirect()->route('kontaks.index')->with('success', 'Kontak berhasil dihapus.');
    }
}
