<?php

namespace App\Http\Controllers;

use App\Services\JsonStore;
use App\Support\Queries;

class OrangtuaController extends Controller
{
    public function __construct(private JsonStore $store)
    {
    }

    private function user(): array
    {
        return session('auth_user');
    }

    private function anakSaya(): array
    {
        $anak = array_values(array_filter(
            $this->store->all('siswa'),
            fn ($s) => $s['nama_orangtua'] === $this->user()['name']
        ));

        if (empty($anak)) {
            $anak = [$this->store->all('siswa')[0]];
        }

        return $anak;
    }

    public function dashboard()
    {
        $anak = $this->anakSaya();
        $log = Queries::logs($this->store);
        $kompetensi = Queries::kompetensiTervalidasi($this->store);

        return view('orangtua.dashboard', [
            'user' => $this->user(),
            'stats' => [
                'anak' => $anak,
                'total_aktivitas' => count($log),
                'kompetensi_tervalidasi' => count($kompetensi),
                'total_anak' => count($anak),
            ],
        ]);
    }

    public function anak()
    {
        $anak = $this->anakSaya();

        $details = collect($anak)->map(function ($s) {
            return [
                ...$s,
                'kompetensi_tervalidasi' => Queries::kompetensiTervalidasi($this->store, $s['id_siswa']),
                'pipeline' => Queries::pipeline($this->store, $s['id_siswa']),
            ];
        })->values()->all();

        return view('orangtua.anak', [
            'user' => $this->user(),
            'anak' => $anak,
            'details' => $details,
        ]);
    }

    public function jalur()
    {
        $anak = $this->anakSaya();

        $jalurPerAnak = collect($anak)->mapWithKeys(function ($s) {
            return [$s['id_siswa'] => Queries::jalurKemandirian($this->store, $s['id_siswa'])];
        })->all();

        return view('orangtua.jalur', [
            'user' => $this->user(),
            'anak' => $anak,
            'jalurPerAnak' => $jalurPerAnak,
        ]);
    }

    public function modul()
    {
        return view('orangtua.modul', [
            'user' => $this->user(),
            'anak' => $this->anakSaya(),
            'modul' => \App\Support\DemoData::modulAjar(),
        ]);
    }
}
