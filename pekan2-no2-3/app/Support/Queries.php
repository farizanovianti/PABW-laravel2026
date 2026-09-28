<?php

namespace App\Support;

use App\Services\JsonStore;

/**
 * "Join" antar tabel store, meniru query model di API CodeIgniter.
 */
class Queries
{
    public const GURU_NAME = 'Rina Kartika';

    public const LEVEL_ORDER = ['belum' => 1, 'dasar' => 2, 'mahir' => 3, 'ahli' => 4];

    public static function logs(JsonStore $store, ?int $siswaId = null): array
    {
        $siswa = collect($store->all('siswa'))->keyBy('id_siswa');
        $keterampilan = collect($store->all('keterampilan'))->keyBy('id_keterampilan');

        return collect($store->all('log_aktivitas'))
            ->filter(fn ($l) => $siswaId === null || (int) $l['id_siswa'] === $siswaId)
            ->map(fn ($l) => [
                ...$l,
                'nama_siswa' => $siswa[$l['id_siswa']]['nama_lengkap'] ?? '-',
                'nama_keterampilan' => $keterampilan[$l['id_keterampilan']]['nama_keterampilan'] ?? '-',
                'kategori' => $keterampilan[$l['id_keterampilan']]['kategori'] ?? '-',
                'nama_guru' => self::GURU_NAME,
            ])
            ->sortByDesc('tanggal_sesi')
            ->values()
            ->all();
    }

    public static function kompetensiTervalidasi(JsonStore $store, ?int $siswaId = null): array
    {
        $logMap = collect($store->all('log_aktivitas'))->keyBy('id_log');
        $keterampilan = collect($store->all('keterampilan'))->keyBy('id_keterampilan');

        return collect($store->all('validasi'))
            ->filter(fn ($v) => $v['keputusan'] === 'disetujui')
            ->filter(function ($v) use ($logMap, $siswaId) {
                $log = $logMap[$v['id_log']] ?? null;

                return $log && ($siswaId === null || (int) $log['id_siswa'] === $siswaId);
            })
            ->map(function ($v) use ($logMap, $keterampilan) {
                $log = $logMap[$v['id_log']];

                return [
                    ...$v,
                    'id_siswa' => $log['id_siswa'],
                    'level_tercapai' => $log['level_tercapai'],
                    'tanggal_sesi' => $log['tanggal_sesi'],
                    'nama_keterampilan' => $keterampilan[$log['id_keterampilan']]['nama_keterampilan'] ?? '-',
                    'kategori' => $keterampilan[$log['id_keterampilan']]['kategori'] ?? '-',
                    'nama_validator' => self::GURU_NAME,
                ];
            })
            ->sortByDesc('tanggal_validasi')
            ->values()
            ->all();
    }

    public static function pipeline(JsonStore $store, ?int $siswaId = null): array
    {
        $siswa = collect($store->all('siswa'))->keyBy('id_siswa');
        $lowongan = collect($store->all('lowongan'))->keyBy('id_lowongan');
        $mitra = collect($store->all('mitra'))->keyBy('id_mitra');

        return collect($store->all('pipeline'))
            ->filter(fn ($p) => $siswaId === null || (int) $p['id_siswa'] === $siswaId)
            ->map(function ($p) use ($siswa, $lowongan, $mitra) {
                $low = $lowongan[$p['id_lowongan']] ?? null;

                return [
                    ...$p,
                    'nama_siswa' => $siswa[$p['id_siswa']]['nama_lengkap'] ?? '-',
                    'kategori_disabilitas' => $siswa[$p['id_siswa']]['kategori_disabilitas'] ?? '-',
                    'judul_posisi' => $low['judul_posisi'] ?? null,
                    'nama_perusahaan' => $low ? ($mitra[$low['id_mitra']]['nama_perusahaan'] ?? null) : null,
                ];
            })
            ->values()
            ->all();
    }

    public static function pengajuan(JsonStore $store, ?string $status = null): array
    {
        $siswa = collect($store->all('siswa'))->keyBy('id_siswa');
        $sekolah = collect($store->all('sekolah'))->keyBy('id_sekolah');

        return collect($store->all('pengajuan'))
            ->filter(fn ($p) => $status === null || $p['status'] === $status)
            ->map(fn ($p) => [
                ...$p,
                'nama_siswa' => $siswa[$p['id_siswa']]['nama_lengkap'] ?? '-',
                'kategori_disabilitas' => $siswa[$p['id_siswa']]['kategori_disabilitas'] ?? '-',
                'nama_sekolah' => $sekolah[$siswa[$p['id_siswa']]['id_sekolah'] ?? null]['nama_sekolah']
                    ?? ($siswa[$p['id_siswa']]['nama_sekolah'] ?? '-'),
                'nama_guru' => self::GURU_NAME,
            ])
            ->sortByDesc('tanggal_pengajuan')
            ->values()
            ->all();
    }

    /**
     * Jalur kemandirian: meniru Log_model::jalur_kemandirian()
     * level_max = level tertinggi dari semua log siswa per keterampilan.
     */
    public static function jalurKemandirian(JsonStore $store, int $siswaId): array
    {
        $keterampilan = collect($store->all('keterampilan'))->keyBy('id_keterampilan');

        return collect($store->all('log_aktivitas'))
            ->filter(fn ($l) => (int) $l['id_siswa'] === $siswaId)
            ->groupBy('id_keterampilan')
            ->map(function ($logs, $idK) use ($keterampilan) {
                $levelMax = $logs->max(fn ($l) => self::LEVEL_ORDER[$l['level_tercapai']] ?? 0);
                $label = array_search($levelMax, self::LEVEL_ORDER, true) ?: 'belum';

                return [
                    'id_keterampilan' => (int) $idK,
                    'nama_keterampilan' => $keterampilan[$idK]['nama_keterampilan'] ?? '-',
                    'kategori' => $keterampilan[$idK]['kategori'] ?? '-',
                    'jumlah_sesi' => $logs->count(),
                    'level_max' => $label,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * Persentase match pipeline: meniru Pipeline_model::_hitung_match()
     */
    public static function hitungMatch(JsonStore $store, int $siswaId, int $lowonganId): int
    {
        $lowongan = $store->find('lowongan', $lowonganId);

        if (! $lowongan || empty($lowongan['id_keterampilan'])) {
            return 50;
        }

        $skillSiswa = collect(self::kompetensiTervalidasi($store, $siswaId))
            ->pluck('nama_keterampilan')
            ->unique();

        return $skillSiswa->contains($lowongan['nama_keterampilan']) ? 100 : 0;
    }

    public static function notifToRole(JsonStore $store, string $role, string $judul, string $pesan): void
    {
        $store->insert('notifikasi', [
            'judul' => $judul,
            'pesan' => $pesan,
            'is_read' => false,
            'role_target' => $role,
        ]);
    }

    public static function logSistem(JsonStore $store, string $deskripsi, string $level = 'info', string $aktor = 'SYSTEM'): void
    {
        $store->insert('log_sistem', [
            'level' => $level,
            'deskripsi' => $deskripsi,
            'aktor' => $aktor,
            'created_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
