<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function form() {
        return view('form');
    }

    public function simpan(Request $request) {

        Mahasiswa::create([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'jurusan' => $request->input('jurusan'),
            'umur' => $request->input('umur'),
        ]);

        return "Data mahasiswa berhasil disimpan.";
    }

    public function daftar() {
        $data = Mahasiswa::all();
        return view('mahasiswa', ['mahasiswa' => $data]);
    }
}
