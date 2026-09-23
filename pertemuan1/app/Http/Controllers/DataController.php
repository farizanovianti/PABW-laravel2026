<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function form()
    {
        return view('form');
    }

    public function proses(Request $request)
    {
        $name = $request->input('name');
        $umur = $request->input('umur');
        $alamat = $request->input('alamat');

        return view('hasil', compact('name', 'umur', 'alamat'));
    }
}