<?php

namespace App\Services;

use App\Support\DemoData;

class JsonStore
{
    private string $path;

    private array $data = [];

    private const TABLE_KEY = [
        'siswa' => 'id_siswa',
        'log_aktivitas' => 'id_log',
        'validasi' => 'id_validasi',
        'pengajuan' => 'id_pengajuan',
        'pipeline' => 'id_pipeline',
        'mitra' => 'id_mitra',
        'lowongan' => 'id_lowongan',
        'sekolah' => 'id_sekolah',
        'keterampilan' => 'id_keterampilan',
        'notifikasi' => 'id_notif',
        'log_sistem' => 'id_log_sistem',
    ];

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? storage_path('app/inkluskill-data.json');

        if (is_file($this->path)) {
            $decoded = json_decode((string) file_get_contents($this->path), true);
            $this->data = is_array($decoded) ? $decoded : [];
        }

        if (empty($this->data)) {
            $this->data = $this->seed();
            $this->save();
        }
    }

    public static function instance(): self
    {
        return app(self::class);
    }

    public function all(string $table): array
    {
        return array_values($this->data[$table] ?? []);
    }

    public function find(string $table, int $id): ?array
    {
        $key = self::TABLE_KEY[$table];

        foreach ($this->data[$table] ?? [] as $row) {
            if ((int) $row[$key] === $id) {
                return $row;
            }
        }

        return null;
    }

    public function insert(string $table, array $row): array
    {
        $key = self::TABLE_KEY[$table];
        $row[$key] = $this->nextId($table);

        if (! isset($this->data[$table])) {
            $this->data[$table] = [];
        }

        $this->data[$table][] = $row;
        $this->save();

        return $row;
    }

    public function update(string $table, int $id, array $changes): ?array
    {
        $key = self::TABLE_KEY[$table];

        foreach ($this->data[$table] ?? [] as $i => $row) {
            if ((int) $row[$key] === $id) {
                $this->data[$table][$i] = [...$row, ...$changes];
                $this->save();

                return $this->data[$table][$i];
            }
        }

        return null;
    }

    public function delete(string $table, int $id): bool
    {
        $key = self::TABLE_KEY[$table];
        $before = count($this->data[$table] ?? []);

        $this->data[$table] = array_values(array_filter(
            $this->data[$table] ?? [],
            fn ($row) => (int) $row[$key] !== $id
        ));

        if (count($this->data[$table]) !== $before) {
            $this->save();

            return true;
        }

        return false;
    }

    public function save(): void
    {
        @mkdir(dirname($this->path), 0777, true);
        file_put_contents($this->path, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function reset(): void
    {
        $this->data = $this->seed();
        $this->save();
    }

    private function nextId(string $table): int
    {
        $key = self::TABLE_KEY[$table];

        return collect($this->data[$table] ?? [])->max($key) + 1;
    }

    private function seed(): array
    {
        // Tabel validasi mentah (meniru tabel validasi_kompetensi di API):
        // dibangun dari log yang berstatus tervalidasi.
        $validasi = collect(DemoData::logAktivitas())
            ->filter(fn ($l) => $l['status_validasi'] === 'tervalidasi' && ! empty($l['id_validasi']))
            ->map(fn ($l) => [
                'id_validasi' => $l['id_validasi'],
                'id_log' => $l['id_log'],
                'id_validator' => 1,
                'keputusan' => 'disetujui',
                'catatan_validasi' => null,
                'tanggal_validasi' => $l['tanggal_validasi'],
            ])
            ->values()
            ->all();

        return [
            'siswa' => DemoData::siswa(),
            'keterampilan' => DemoData::keterampilan(),
            'log_aktivitas' => DemoData::logAktivitas(),
            'validasi' => $validasi,
            'pengajuan' => DemoData::pengajuan(),
            'mitra' => DemoData::mitra(),
            'lowongan' => DemoData::lowongan(),
            'pipeline' => DemoData::pipeline(),
            'sekolah' => DemoData::sekolah(),
            'notifikasi' => [
                ...array_map(fn ($n) => [...$n, 'role_target' => 'guru'], DemoData::notifikasiGuru()),
                ...array_map(fn ($n) => [...$n, 'role_target' => 'dinas'], DemoData::notifikasiDinas()),
            ],
            'log_sistem' => DemoData::logSistem(),
        ];
    }
}
