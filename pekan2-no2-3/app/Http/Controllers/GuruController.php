<?php

namespace App\Http\Controllers;

use App\Services\JsonStore;
use App\Support\DemoData;
use App\Support\Queries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
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
        $siswa = $this->store->all('siswa');
        $log = Queries::logs($this->store);

        return view('guru.dashboard', [
            'user' => $this->user(),
            'stats' => [
                'total_siswa' => count($siswa),
                'total_sesi' => count($log),
                'menunggu_validasi' => count(array_filter($log, fn ($l) => $l['status_validasi'] === 'menunggu')),
                'total_pengajuan' => count($this->store->all('pengajuan')),
            ],
            'siswa' => $siswa,
            'notif' => array_slice(
                array_filter($this->store->all('notifikasi'), fn ($n) => $n['role_target'] === 'guru'),
                0,
                5
            ),
        ]);
    }

    public function siswaIndex()
    {
        $siswa = $this->store->all('siswa');

        return view('guru.siswa', [
            'user' => $this->user(),
            'siswa' => $siswa,
            'disabilitas' => $this->kategoriDisabilitas(),
        ]);
    }

    public function siswaStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => ['required'],
            'kategori_disabilitas' => ['required'],
        ], [
            'nama_lengkap.required' => 'nama_lengkap wajib diisi',
            'kategori_disabilitas.required' => 'kategori_disabilitas wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->only(['mode', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'kategori_disabilitas', 'kelas', 'nama_orangtua', 'kontak_orangtua', 'status']))
                ->withErrors($validator);
        }

        $this->store->insert('siswa', [
            'nama_lengkap' => trim($request->input('nama_lengkap')),
            'tanggal_lahir' => $request->input('tanggal_lahir') ?: null,
            'jenis_kelamin' => $request->input('jenis_kelamin', 'L'),
            'id_sekolah' => 1,
            'nama_sekolah' => 'SLB Negeri 1 Bandung',
            'kota_kabupaten' => 'Kota Bandung',
            'kelas' => $request->input('kelas') ?: null,
            'kategori_disabilitas' => $request->input('kategori_disabilitas'),
            'nama_orangtua' => $request->input('nama_orangtua') ?: null,
            'kontak_orangtua' => $request->input('kontak_orangtua') ?: null,
            'tahun_masuk' => (int) date('Y'),
            'status' => $request->input('status', 'aktif'),
        ]);

        return redirect()
            ->route('guru.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }

    public function siswaUpdate(Request $request, int $id)
    {
        $siswa = $this->store->find('siswa', $id);

        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan atau bukan siswa Anda');
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => ['required'],
            'kategori_disabilitas' => ['required'],
        ], [
            'nama_lengkap.required' => 'nama_lengkap wajib diisi',
            'kategori_disabilitas.required' => 'kategori_disabilitas wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->all())
                ->withErrors($validator);
        }

        $allowed = ['nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'kelas', 'kategori_disabilitas', 'status'];
        $changes = [];

        foreach ($allowed as $field) {
            if ($request->filled($field) || in_array($field, ['status', 'jenis_kelamin'], true)) {
                $changes[$field] = $request->input($field) ?: null;
            }
        }
        if ($request->filled('nama_lengkap')) {
            $changes['nama_lengkap'] = trim($request->input('nama_lengkap'));
        }
        if ($request->filled('kategori_disabilitas')) {
            $changes['kategori_disabilitas'] = $request->input('kategori_disabilitas');
        }

        if (empty($changes)) {
            return back()->with('error', 'Tidak ada data yang diperbarui');
        }

        $this->store->update('siswa', $id, $changes);

        return redirect()
            ->route('guru.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function siswaDestroy(int $id)
    {
        if (! $this->store->find('siswa', $id)) {
            return back()->with('error', 'Siswa tidak ditemukan atau bukan siswa Anda');
        }

        $this->store->delete('siswa', $id);
        $this->deleteRelated('log_aktivitas', 'id_siswa', $id);
        $this->deleteRelated('pengajuan', 'id_siswa', $id);
        $this->deleteRelated('pipeline', 'id_siswa', $id);

        return redirect()
            ->route('guru.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }

    public function siswaShow(int $id)
    {
        $siswa = $this->store->find('siswa', $id);

        abort_if(! $siswa, 404);

        return view('guru.profil-siswa', [
            'user' => $this->user(),
            'siswa' => $siswa,
            'log_aktivitas' => Queries::logs($this->store, $id),
            'kompetensi_validated' => Queries::kompetensiTervalidasi($this->store, $id),
            'pipeline' => Queries::pipeline($this->store, $id),
            'keterampilan' => $this->store->all('keterampilan'),
        ]);
    }

    // fitur 2 input log
    public function logStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => ['required', 'integer'],
            'id_keterampilan' => ['required', 'integer'],
            'level_tercapai' => ['required', 'in:belum,dasar,mahir,ahli'],
            'tanggal_sesi' => ['required', 'date'],
        ], [
            'id_siswa.required' => "Field 'id_siswa' wajib",
            'id_keterampilan.required' => "Field 'id_keterampilan' wajib",
            'level_tercapai.required' => "Field 'level_tercapai' wajib",
            'level_tercapai.in' => 'level_tercapai harus belum, dasar, mahir, atau ahli',
            'tanggal_sesi.required' => "Field 'tanggal_sesi' wajib",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $siswa = $this->store->find('siswa', (int) $request->input('id_siswa'));
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan atau bukan siswa Anda');
        }

        $this->store->insert('log_aktivitas', [
            'id_siswa' => (int) $request->input('id_siswa'),
            'id_guru' => 1,
            'id_keterampilan' => (int) $request->input('id_keterampilan'),
            'level_tercapai' => $request->input('level_tercapai'),
            'status_validasi' => 'menunggu',
            'catatan_guru' => $request->input('catatan_guru') ?: null,
            'tanggal_sesi' => $request->input('tanggal_sesi'),
            'created_at' => now()->format('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->route('guru.siswa.show', $siswa['id_siswa'])
            ->with('success', 'Log aktivitas berhasil disimpan');
    }

    // fitur 2 validasi
    public function validasiIndex()
    {
        $pending = array_values(array_filter(
            Queries::logs($this->store),
            fn ($l) => $l['status_validasi'] === 'menunggu'
        ));

        return view('guru.validasi', [
            'user' => $this->user(),
            'pending' => $pending,
        ]);
    }

    public function validasiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_log' => ['required', 'integer'],
            'keputusan' => ['required', 'in:disetujui,perlu_revisi'],
        ], [
            'id_log.required' => "Field 'id_log' wajib",
            'keputusan.required' => "Field 'keputusan' wajib",
            'keputusan.in' => 'keputusan harus disetujui atau perlu_revisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $idLog = (int) $request->input('id_log');
        $log = $this->store->find('log_aktivitas', $idLog);

        if (! $log) {
            return back()->with('error', 'Log tidak ditemukan');
        }

        $keputusan = $request->input('keputusan');

        // jika log sudah divalidasi, perbarui. kalo belum, buat baru
        $existing = collect($this->store->all('validasi'))->firstWhere('id_log', $idLog);

        if ($existing) {
            $this->store->update('validasi', $existing['id_validasi'], [
                'keputusan' => $keputusan,
                'catatan_validasi' => $request->input('catatan_validasi') ?: null,
                'tanggal_validasi' => now()->format('Y-m-d H:i:s'),
            ]);
            $message = 'Validasi diperbarui';
        } else {
            $this->store->insert('validasi', [
                'id_log' => $idLog,
                'id_validator' => 1,
                'keputusan' => $keputusan,
                'catatan_validasi' => $request->input('catatan_validasi') ?: null,
                'tanggal_validasi' => now()->format('Y-m-d H:i:s'),
            ]);
            $message = 'Validasi berhasil disimpan';
        }

        // proses: status log berubah sesuai keputusan
        $this->store->update('log_aktivitas', $idLog, [
            'status_validasi' => $keputusan === 'disetujui' ? 'tervalidasi' : 'perlu_revisi',
        ]);

        return redirect()
            ->route('guru.validasi')
            ->with('success', $message);
    }

    public function pengajuanIndex()
    {
        return view('guru.pengajuan', [
            'user' => $this->user(),
            'pengajuan' => Queries::pengajuan($this->store),
            'siswa' => $this->store->all('siswa'),
        ]);
    }

    // fitur 3 mengajukan siswa ke dinas
    public function pengajuanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => ['required', 'integer'],
        ], [
            'id_siswa.required' => 'id_siswa wajib',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $siswa = $this->store->find('siswa', (int) $request->input('id_siswa'));
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan atau bukan siswa Anda');
        }

        $this->store->insert('pengajuan', [
            'id_siswa' => $siswa['id_siswa'],
            'id_guru' => 1,
            'keterangan' => $request->input('keterangan') ?: null,
            'status' => 'diajukan',
            'catatan_dinas' => null,
            'tanggal_pengajuan' => now()->format('Y-m-d H:i:s'),
        ]);

        // output: notifikasi ke dinas
        Queries::notifToRole(
            $this->store,
            'dinas',
            'Pengajuan Siswa Baru',
            $this->user()['name'].' mengajukan '.$siswa['nama_lengkap'].' untuk penyaluran'
        );

        return redirect()
            ->route('guru.pengajuan')
            ->with('success', 'Pengajuan berhasil dikirim ke dinas');
    }

    public function modul()
    {
        $modul = array_map(function ($m) {
            $langkah = $m['langkah'];
            usort($langkah, fn ($a, $b) => $a['urutan'] <=> $b['urutan']);
            $m['langkah'] = $langkah;

            return $m;
        }, DemoData::modulAjar());

        return view('guru.modul', [
            'user' => $this->user(),
            'modul' => $modul,
            'keterampilan' => $this->store->all('keterampilan'),
        ]);
    }

    private function kategoriDisabilitas(): array
    {
        return [
            ['id_kategori' => 1, 'nama' => 'Tuna Rungu'],
            ['id_kategori' => 2, 'nama' => 'Tuna Grahita Ringan'],
            ['id_kategori' => 3, 'nama' => 'Tuna Daksa'],
            ['id_kategori' => 4, 'nama' => 'Autis'],
            ['id_kategori' => 5, 'nama' => 'Tuna Netra'],
        ];
    }

    private function deleteRelated(string $table, string $foreignKey, int $id): void
    {
        $key = collect([
            'log_aktivitas' => 'id_log',
            'pengajuan' => 'id_pengajuan',
            'pipeline' => 'id_pipeline',
        ])->get($table);

        $rows = array_filter(
            $this->store->all($table),
            fn ($row) => (int) $row[$foreignKey] === $id
        );

        foreach ($rows as $row) {
            $this->store->delete($table, (int) $row[$key]);
        }
    }
}
