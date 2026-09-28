<?php

namespace App\Http\Controllers;

use App\Services\JsonStore;
use App\Support\Queries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DinasController extends Controller
{
    public function __construct(private JsonStore $store)
    {
    }

    private function user(): array
    {
        return session('auth_user');
    }

    public function dashboard()
    {
        $pipeline = $this->store->all('pipeline');

        $proses = count(array_filter(
            $pipeline,
            fn ($p) => in_array($p['status_tahap'], ['direkomendasikan', 'wawancara', 'penawaran'], true)
        ));
        $diterima = count(array_filter($pipeline, fn ($p) => $p['status_tahap'] === 'diterima'));

        return view('dinas.dashboard', [
            'user' => $this->user(),
            'stats' => [
                'total_siswa' => count($this->store->all('siswa')),
                'total_sekolah' => count(array_filter(
                    $this->store->all('sekolah'),
                    fn ($s) => $s['status_verifikasi'] === 'terverifikasi'
                )),
                'total_mitra' => count(array_filter(
                    $this->store->all('mitra'),
                    fn ($m) => $m['status'] === 'aktif'
                )),
                'pengajuan_baru' => count(array_filter(
                    $this->store->all('pengajuan'),
                    fn ($p) => $p['status'] === 'diajukan'
                )),
                'pipeline_proses' => $proses,
                'pipeline_diterima' => $diterima,
            ],
            'notif' => array_slice(
                array_filter($this->store->all('notifikasi'), fn ($n) => $n['role_target'] === 'dinas'),
                0,
                5
            ),
        ]);
    }

    public function siswaIndex()
    {
        $siswa = $this->store->all('siswa');

        return view('dinas.siswa', [
            'user' => $this->user(),
            'siswa' => $siswa,
            'kotaList' => array_values(array_unique(array_filter(array_column($siswa, 'kota_kabupaten')))),
        ]);
    }

    public function siswaShow(int $id)
    {
        $siswa = $this->store->find('siswa', $id);

        abort_if(! $siswa, 404);

        return view('dinas.profil-siswa', [
            'user' => $this->user(),
            'siswa' => $siswa,
            'log_aktivitas' => Queries::logs($this->store, $id),
            'kompetensi_tervalidasi' => Queries::kompetensiTervalidasi($this->store, $id),
            'pengajuan' => array_values(array_filter(
                Queries::pengajuan($this->store),
                fn ($p) => (int) $p['id_siswa'] === $id
            )),
            'pipeline' => Queries::pipeline($this->store, $id),
        ]);
    }

    public function pengajuanIndex(Request $request)
    {
        $status = $request->query('status');

        return view('dinas.pengajuan', [
            'user' => $this->user(),
            'filter' => $status,
            'list' => Queries::pengajuan($this->store, $status),
        ]);
    }

    // fitur 3 review pengajuan
    public function pengajuanReview(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'in:diterima,dikembalikan'],
        ], [
            'status.required' => 'status wajib (diterima/dikembalikan)',
            'status.in' => 'Status tidak valid',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $pengajuan = $this->store->find('pengajuan', $id);
        if (! $pengajuan) {
            return back()->with('error', 'Pengajuan tidak ditemukan');
        }

        $status = $request->input('status');
        $namaSiswa = $this->store->find('siswa', (int) $pengajuan['id_siswa'])['nama_lengkap'] ?? 'siswa';

        // proses review: status + catatan + reviewer + tanggal review
        $this->store->update('pengajuan', $id, [
            'status' => $status,
            'catatan_dinas' => $request->input('catatan') ?: null,
            'id_reviewer' => 3,
            'tanggal_review' => now()->format('Y-m-d H:i:s'),
        ]);

        Queries::logSistem(
            $this->store,
            'Pengajuan #'.$id.' ('.$namaSiswa.') direview: '.$status,
            'info',
            'dinas.andi'
        );

        Queries::notifToRole(
            $this->store,
            'guru',
            'Pengajuan '.ucfirst($status),
            'Pengajuan '.$namaSiswa.' telah '.$status.' oleh dinas'
        );

        return redirect()
            ->route('dinas.pengajuan')
            ->with('success', 'Pengajuan berhasil di-review');
    }

    public function pipelineIndex()
    {
        $pengajuanDiterima = [];
        $seen = [];

        foreach (Queries::pengajuan($this->store, 'diterima') as $p) {
            if (in_array($p['id_siswa'], $seen, true)) {
                continue;
            }
            $seen[] = $p['id_siswa'];
            $pengajuanDiterima[] = $p;
        }

        return view('dinas.pipeline', [
            'user' => $this->user(),
            'pipeline' => Queries::pipeline($this->store),
            'pengajuan' => $pengajuanDiterima,
            'lowongan' => array_values(array_filter(
                $this->store->all('lowongan'),
                fn ($l) => $l['status'] === 'buka'
            )),
        ]);
    }

    // fitur 3 tambah ke pipeline dengan persentase match
    public function pipelineStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pengajuan' => ['required', 'integer'],
            'id_lowongan' => ['required', 'integer'],
        ], [
            'id_pengajuan.required' => "Field 'id_pengajuan' wajib",
            'id_lowongan.required' => "Field 'id_lowongan' wajib",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $pengajuan = $this->store->find('pengajuan', (int) $request->input('id_pengajuan'));
        if (! $pengajuan) {
            return back()->with('error', 'Pengajuan tidak ditemukan');
        }
        if ($pengajuan['status'] !== 'diterima') {
            return back()->with('error', 'Pengajuan belum diterima dinas');
        }

        $lowongan = $this->store->find('lowongan', (int) $request->input('id_lowongan'));
        if (! $lowongan) {
            return back()->with('error', 'Lowongan tidak ditemukan');
        }

        $idSiswa = (int) $pengajuan['id_siswa'];

        // proses: hitung persentase match dari kompetensi tervalidasi siswa
        $match = Queries::hitungMatch($this->store, $idSiswa, $lowongan['id_lowongan']);

        $this->store->insert('pipeline', [
            'id_pengajuan' => $pengajuan['id_pengajuan'],
            'id_siswa' => $idSiswa,
            'id_lowongan' => $lowongan['id_lowongan'],
            'persentase_match' => $match,
            'status_tahap' => 'direkomendasikan',
            'catatan' => null,
            'id_update_oleh' => 3,
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]);

        Queries::logSistem(
            $this->store,
            'Pipeline dibuat: siswa #'.$idSiswa.' direkomendasikan ke lowongan "'.$lowongan['judul_posisi'].'" (match '.$match.'%)',
            'info',
            'dinas.andi'
        );

        return redirect()
            ->route('dinas.pipeline')
            ->with('success', 'Pipeline berhasil dibuat (match '.$match.'%)');
    }

    // fitur 3 update tahap pipeline
    public function pipelineUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'status_tahap' => ['required', 'in:direkomendasikan,wawancara,penawaran,diterima,ditolak'],
        ], [
            'status_tahap.required' => 'status_tahap wajib',
            'status_tahap.in' => 'status_tahap tidak valid',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if (! $this->store->find('pipeline', $id)) {
            return back()->with('error', 'Pipeline tidak ditemukan');
        }

        $this->store->update('pipeline', $id, [
            'status_tahap' => $request->input('status_tahap'),
            'catatan' => $request->input('catatan') ?: null,
            'id_update_oleh' => 3,
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->route('dinas.pipeline')
            ->with('success', 'Status pipeline diperbarui');
    }

    public function mitra()
    {
        $mitra = $this->store->all('mitra');

        $withLowongan = collect($mitra)->map(function ($m) {
            return [
                ...$m,
                'lowongan' => array_values(array_filter(
                    $this->store->all('lowongan'),
                    fn ($l) => $l['id_mitra'] === $m['id_mitra']
                )),
            ];
        })->values()->all();

        return view('dinas.mitra', [
            'user' => $this->user(),
            'mitra' => $withLowongan,
            'keterampilan' => $this->store->all('keterampilan'),
        ]);
    }

    public function master()
    {
        return view('dinas.master', [
            'user' => $this->user(),
            'keterampilan' => $this->store->all('keterampilan'),
            'sekolah' => $this->store->all('sekolah'),
            'logSistem' => $this->store->all('log_sistem'),
        ]);
    }
}
