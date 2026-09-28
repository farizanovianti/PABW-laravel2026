<?php

namespace App\Http\Controllers;

use App\Support\DemoData;

class HomeController extends Controller
{
    public function landing()
    {
        return view('pages.landing', [
            'stats' => DemoData::publicStats(),
        ]);
    }
}
