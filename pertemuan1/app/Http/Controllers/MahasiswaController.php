<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class MahasiswaController extends Controller {
    public function formmhs()
    {
        return view('formmhs');
    }

    public function prosesmhs(Request $requestdata)
    {
        $nim = $requestdata->input('nim');
        $nama = $requestdata->input('nama');
        $prodi = $requestdata->input('prodi');
        $semester = $requestdata->input('semester');

        return view('hasilmhs', compact('nim', 'nama', 'prodi', 'semester'));
    }
}