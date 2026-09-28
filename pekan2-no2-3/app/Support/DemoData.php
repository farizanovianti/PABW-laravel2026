<?php

namespace App\Support;

class DemoData
{
    public static function users(): array
    {
        return [
            [
                'email' => 'guru@inkluskill.id',
                'password' => 'password',
                'name' => 'Rina Kartika',
                'role' => 'guru',
                'extra' => ['nama_sekolah' => 'SLB Negeri 1 Bandung', 'kelas_ajar' => 'Kelas X'],
            ],
            [
                'email' => 'orangtua@inkluskill.id',
                'password' => 'password',
                'name' => 'Siti Rahayu',
                'role' => 'orang_tua',
                'extra' => ['hubungan_abk' => 'orang_tua'],
            ],
            [
                'email' => 'dinas@inkluskill.id',
                'password' => 'password',
                'name' => 'Andi Pratama',
                'role' => 'dinas',
                'extra' => ['unit_kerja' => 'Dinas Pendidikan Kota Bandung'],
            ],
        ];
    }

    public static function kategoriDisabilitas(): array
    {
        return [
            ['id_kategori' => 1, 'nama' => 'Tuna Rungu'],
            ['id_kategori' => 2, 'nama' => 'Tuna Grahita Ringan'],
            ['id_kategori' => 3, 'nama' => 'Tuna Daksa'],
            ['id_kategori' => 4, 'nama' => 'Autis'],
            ['id_kategori' => 5, 'nama' => 'Tuna Netra'],
        ];
    }

    public static function keterampilan(): array
    {
        return [
            ['id_keterampilan' => 1, 'nama_keterampilan' => 'Menjahit Dasar', 'kategori' => 'Tata Busana', 'deskripsi' => 'Keterampilan menjahit dasar hingga produksi sederhana.', 'jumlah_siswa' => 4, 'status' => 'aktif'],
            ['id_keterampilan' => 2, 'nama_keterampilan' => 'Memasak Nasi Goreng', 'kategori' => 'Kuliner', 'deskripsi' => 'Pengolahan makanan sederhana untuk kemandirian.', 'jumlah_siswa' => 5, 'status' => 'aktif'],
            ['id_keterampilan' => 3, 'nama_keterampilan' => 'Barista Dasar', 'kategori' => 'Kuliner', 'deskripsi' => 'Penyajian kopi dan minuman sederhana.', 'jumlah_siswa' => 3, 'status' => 'aktif'],
            ['id_keterampilan' => 4, 'nama_keterampilan' => 'Merawat Tanaman', 'kategori' => 'Agribisnis', 'deskripsi' => 'Budidaya tanaman hias dan sayuran sederhana.', 'jumlah_siswa' => 2, 'status' => 'aktif'],
            ['id_keterampilan' => 5, 'nama_keterampilan' => 'Desain Grafis Sederhana', 'kategori' => 'Industri Kreatif', 'deskripsi' => 'Desain sederhana menggunakan aplikasi gratis.', 'jumlah_siswa' => 3, 'status' => 'nonaktif'],
            ['id_keterampilan' => 6, 'nama_keterampilan' => 'Kerajinan Makrame', 'kategori' => 'Seni Kriya', 'deskripsi' => 'Membuat produk kerajinan tangan dari tali.', 'jumlah_siswa' => 2, 'status' => 'aktif'],
        ];
    }

    public static function siswa(): array
    {
        return [
            ['id_siswa' => 1, 'nama_lengkap' => 'Ahmad Fauzi', 'tanggal_lahir' => '2008-04-12', 'jenis_kelamin' => 'L', 'kelas' => 'X-A', 'kategori_disabilitas' => 'Tuna Rungu', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'kota_kabupaten' => 'Kota Bandung', 'status' => 'aktif', 'nama_orangtua' => 'Siti Rahayu', 'kontak_orangtua' => '081234567890', 'tahun_masuk' => 2023],
            ['id_siswa' => 2, 'nama_lengkap' => 'Dewi Lestari', 'tanggal_lahir' => '2009-01-25', 'jenis_kelamin' => 'P', 'kelas' => 'X-A', 'kategori_disabilitas' => 'Tuna Grahita Ringan', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'kota_kabupaten' => 'Kota Bandung', 'status' => 'aktif', 'nama_orangtua' => 'Budi Santoso', 'kontak_orangtua' => '081298765432', 'tahun_masuk' => 2024],
            ['id_siswa' => 3, 'nama_lengkap' => 'Rizky Ramadhan', 'tanggal_lahir' => '2007-09-03', 'jenis_kelamin' => 'L', 'kelas' => 'XI-B', 'kategori_disabilitas' => 'Tuna Daksa', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'kota_kabupaten' => 'Kota Bandung', 'status' => 'aktif', 'nama_orangtua' => 'Joko Widodo', 'kontak_orangtua' => '081211122233', 'tahun_masuk' => 2022],
            ['id_siswa' => 4, 'nama_lengkap' => 'Sinta Melati', 'tanggal_lahir' => '2008-12-18', 'jenis_kelamin' => 'P', 'kelas' => 'X-B', 'kategori_disabilitas' => 'Autis', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'kota_kabupaten' => 'Kota Bandung', 'status' => 'nonaktif', 'nama_orangtua' => 'Agus Salim', 'kontak_orangtua' => '081244455566', 'tahun_masuk' => 2023],
            ['id_siswa' => 5, 'nama_lengkap' => 'Bagas Pratama', 'tanggal_lahir' => '2009-06-30', 'jenis_kelamin' => 'L', 'kelas' => 'X-A', 'kategori_disabilitas' => 'Tuna Rungu', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'kota_kabupaten' => 'Kota Bandung', 'status' => 'aktif', 'nama_orangtua' => 'Hendra Gunawan', 'kontak_orangtua' => '081277788899', 'tahun_masuk' => 2024],
            ['id_siswa' => 6, 'nama_lengkap' => 'Nadia Putri', 'tanggal_lahir' => '2008-03-08', 'jenis_kelamin' => 'P', 'kelas' => 'XI-B', 'kategori_disabilitas' => 'Tuna Grahita Ringan', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'kota_kabupaten' => 'Kota Bandung', 'status' => 'aktif', 'nama_orangtua' => 'Siti Rahayu', 'kontak_orangtua' => '081234567890', 'tahun_masuk' => 2023],
        ];
    }

    public static function logAktivitas(): array
    {
        return [
            ['id_log' => 1, 'id_siswa' => 1, 'id_keterampilan' => 2, 'nama_keterampilan' => 'Memasak Nasi Goreng', 'nama_guru' => 'Rina Kartika', 'level_tercapai' => 'mahir', 'status_validasi' => 'tervalidasi', 'catatan_guru' => 'Siswa sudah bisa memasak nasi goreng mandiri dari persiapan hingga plating.', 'tanggal_sesi' => '2026-09-20', 'id_validasi' => 1, 'nama_validator' => 'Rina Kartika', 'tanggal_validasi' => '2026-09-21 10:00:00'],
            ['id_log' => 2, 'id_siswa' => 1, 'id_keterampilan' => 3, 'nama_keterampilan' => 'Barista Dasar', 'nama_guru' => 'Rina Kartika', 'level_tercapai' => 'dasar', 'status_validasi' => 'menunggu', 'catatan_guru' => 'Siswa mulai belajar menyeduh kopi manual brew dengan bimbingan.', 'tanggal_sesi' => '2026-09-24', 'id_validasi' => null, 'nama_validator' => null, 'tanggal_validasi' => null],
            ['id_log' => 3, 'id_siswa' => 2, 'id_keterampilan' => 1, 'nama_keterampilan' => 'Menjahit Dasar', 'nama_guru' => 'Rina Kartika', 'level_tercapai' => 'mahir', 'status_validasi' => 'tervalidasi', 'catatan_guru' => 'Jahitan rapi dan konsisten, siap lanjut ke pola dasar.', 'tanggal_sesi' => '2026-09-18', 'id_validasi' => 2, 'nama_validator' => 'Rina Kartika', 'tanggal_validasi' => '2026-09-19 09:30:00'],
            ['id_log' => 4, 'id_siswa' => 2, 'id_keterampilan' => 6, 'nama_keterampilan' => 'Kerajinan Makrame', 'nama_guru' => 'Rina Kartika', 'level_tercapai' => 'dasar', 'status_validasi' => 'menunggu', 'catatan_guru' => 'Siswa dapat mengikuti pola simpul dasar makrame.', 'tanggal_sesi' => '2026-09-25', 'id_validasi' => null, 'nama_validator' => null, 'tanggal_validasi' => null],
            ['id_log' => 5, 'id_siswa' => 3, 'id_keterampilan' => 4, 'nama_keterampilan' => 'Merawat Tanaman', 'nama_guru' => 'Rina Kartika', 'level_tercapai' => 'ahli', 'status_validasi' => 'tervalidasi', 'catatan_guru' => 'Siswa mandiri merawat kebun sekolah dan membimbing teman.', 'tanggal_sesi' => '2026-09-15', 'id_validasi' => 3, 'nama_validator' => 'Rina Kartika', 'tanggal_validasi' => '2026-09-16 13:00:00'],
            ['id_log' => 6, 'id_siswa' => 5, 'id_keterampilan' => 2, 'nama_keterampilan' => 'Memasak Nasi Goreng', 'nama_guru' => 'Rina Kartika', 'level_tercapai' => 'dasar', 'status_validasi' => 'menunggu', 'catatan_guru' => 'Siswa belajar persiapan bahan dengan supervisi.', 'tanggal_sesi' => '2026-09-26', 'id_validasi' => null, 'nama_validator' => null, 'tanggal_validasi' => null],
        ];
    }

    public static function kompetensiTervalidasi(): array
    {
        return [
            ['id_validasi' => 1, 'id_siswa' => 1, 'nama_keterampilan' => 'Memasak Nasi Goreng', 'level_tercapai' => 'mahir', 'nama_validator' => 'Rina Kartika', 'tanggal_validasi' => '2026-09-21 10:00:00', 'catatan_validasi' => 'Konsisten di level mahir 3 sesi berturut.'],
            ['id_validasi' => 2, 'id_siswa' => 2, 'nama_keterampilan' => 'Menjahit Dasar', 'level_tercapai' => 'mahir', 'nama_validator' => 'Rina Kartika', 'tanggal_validasi' => '2026-09-19 09:30:00', 'catatan_validasi' => 'Siap diajukan ke mitra konfeksi.'],
            ['id_validasi' => 3, 'id_siswa' => 3, 'nama_keterampilan' => 'Merawat Tanaman', 'level_tercapai' => 'ahli', 'nama_validator' => 'Rina Kartika', 'tanggal_validasi' => '2026-09-16 13:00:00', 'catatan_validasi' => 'Sangat mandiri, potensi kerja di nursery.'],
            ['id_validasi' => 4, 'id_siswa' => 6, 'nama_keterampilan' => 'Barista Dasar', 'level_tercapai' => 'dasar', 'nama_validator' => 'Rina Kartika', 'tanggal_validasi' => '2026-09-10 11:00:00', 'catatan_validasi' => 'Perlu latihan kecepatan penyajian.'],
        ];
    }

    public static function pengajuan(): array
    {
        return [
            ['id_pengajuan' => 1, 'id_siswa' => 1, 'id_guru' => 1, 'nama_siswa' => 'Ahmad Fauzi', 'kategori_disabilitas' => 'Tuna Rungu', 'nama_guru' => 'Rina Kartika', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'keterangan' => 'Siswa memiliki kompetensi memasak level mahir, siap magang di dapur mitra kuliner.', 'status' => 'diterima', 'catatan_dinas' => 'Siap diproses matching ke mitra kuliner.', 'tanggal_pengajuan' => '2026-09-21 10:30:00'],
            ['id_pengajuan' => 2, 'id_siswa' => 2, 'id_guru' => 1, 'nama_siswa' => 'Dewi Lestari', 'kategori_disabilitas' => 'Tuna Grahita Ringan', 'nama_guru' => 'Rina Kartika', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'keterangan' => 'Kompetensi menjahit level mahir, disarankan magang di konfeksi.', 'status' => 'diajukan', 'catatan_dinas' => null, 'tanggal_pengajuan' => '2026-09-25 08:15:00'],
            ['id_pengajuan' => 3, 'id_siswa' => 3, 'id_guru' => 1, 'nama_siswa' => 'Rizky Ramadhan', 'kategori_disabilitas' => 'Tuna Daksa', 'nama_guru' => 'Rina Kartika', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'keterangan' => 'Ahli merawat tanaman, calon pekerja nursery.', 'status' => 'diterima', 'catatan_dinas' => 'Akan dicocokkan dengan mitra agribisnis.', 'tanggal_pengajuan' => '2026-09-18 14:00:00'],
            ['id_pengajuan' => 4, 'id_siswa' => 4, 'id_guru' => 1, 'nama_siswa' => 'Sinta Melati', 'kategori_disabilitas' => 'Autis', 'nama_guru' => 'Rina Kartika', 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'keterangan' => 'Perlu pendampingan tambahan sebelum penyaluran.', 'status' => 'dikembalikan', 'catatan_dinas' => 'Mohon lengkapi laporan observasi terbaru.', 'tanggal_pengajuan' => '2026-09-12 09:45:00'],
        ];
    }

    public static function mitra(): array
    {
        return [
            ['id_mitra' => 1, 'nama_perusahaan' => 'Kopi Kina Cafe', 'bidang_usaha' => 'Kuliner', 'kota_kabupaten' => 'Kota Bandung', 'kontak_pic' => 'Maya Anggraini', 'nomor_telepon' => '081211110001', 'email' => 'hr@kopikina.id', 'status' => 'aktif'],
            ['id_mitra' => 2, 'nama_perusahaan' => 'Konfeksi Cahaya', 'bidang_usaha' => 'Tata Busana', 'kota_kabupaten' => 'Kota Cimahi', 'kontak_pic' => 'Bambang Wijaya', 'nomor_telepon' => '081211110002', 'email' => 'bambang@konfeksicahaya.co.id', 'status' => 'aktif'],
            ['id_mitra' => 3, 'nama_perusahaan' => 'Nursery Hijau Asri', 'bidang_usaha' => 'Agribisnis', 'kota_kabupaten' => 'Kab. Bandung Barat', 'kontak_pic' => 'Lina Marlina', 'nomor_telepon' => '081211110003', 'email' => 'lina@hijauasri.id', 'status' => 'aktif'],
            ['id_mitra' => 4, 'nama_perusahaan' => 'Kriya Nusantara', 'bidang_usaha' => 'Seni Kriya', 'kota_kabupaten' => 'Kota Bandung', 'kontak_pic' => 'Dedi Kurniawan', 'nomor_telepon' => '081211110004', 'email' => 'dedi@kriyanusantara.id', 'status' => 'nonaktif'],
        ];
    }

    public static function lowongan(): array
    {
        return [
            ['id_lowongan' => 1, 'id_mitra' => 1, 'id_keterampilan' => 3, 'nama_keterampilan' => 'Barista Dasar', 'nama_perusahaan' => 'Kopi Kina Cafe', 'judul_posisi' => 'Barista Junior', 'jumlah_posisi' => 2, 'deskripsi' => 'Menyiapkan dan menyajikan minuman kopi sederhana dengan pendampingan senior.', 'deadline' => '2026-10-31', 'status' => 'buka'],
            ['id_lowongan' => 2, 'id_mitra' => 2, 'id_keterampilan' => 1, 'nama_keterampilan' => 'Menjahit Dasar', 'nama_perusahaan' => 'Konfeksi Cahaya', 'judul_posisi' => 'Operator Jahit', 'jumlah_posisi' => 3, 'deskripsi' => 'Menjalankan mesin jahit untuk produksi seragam.', 'deadline' => '2026-10-15', 'status' => 'buka'],
            ['id_lowongan' => 3, 'id_mitra' => 3, 'id_keterampilan' => 4, 'nama_keterampilan' => 'Merawat Tanaman', 'nama_perusahaan' => 'Nursery Hijau Asri', 'judul_posisi' => 'Penjaga Nursery', 'jumlah_posisi' => 1, 'deskripsi' => 'Merawat tanaman hias dan menyiapkan media tanam.', 'deadline' => '2026-11-30', 'status' => 'buka'],
            ['id_lowongan' => 4, 'id_mitra' => 1, 'id_keterampilan' => 2, 'nama_keterampilan' => 'Memasak Nasi Goreng', 'nama_perusahaan' => 'Kopi Kina Cafe', 'judul_posisi' => 'Helper Dapur', 'jumlah_posisi' => 1, 'deskripsi' => 'Membantu persiapan bahan dan plating di dapur.', 'deadline' => '2026-09-30', 'status' => 'tutup'],
        ];
    }

    public static function pipeline(): array
    {
        return [
            ['id_pipeline' => 1, 'id_siswa' => 1, 'id_lowongan' => 4, 'nama_siswa' => 'Ahmad Fauzi', 'kategori_disabilitas' => 'Tuna Rungu', 'nama_perusahaan' => 'Kopi Kina Cafe', 'judul_posisi' => 'Helper Dapur', 'status_tahap' => 'diterima', 'persentase_match' => 87, 'catatan' => 'Diterima mulai bulan depan.'],
            ['id_pipeline' => 2, 'id_siswa' => 3, 'id_lowongan' => 3, 'nama_siswa' => 'Rizky Ramadhan', 'kategori_disabilitas' => 'Tuna Daksa', 'nama_perusahaan' => 'Nursery Hijau Asri', 'judul_posisi' => 'Penjaga Nursery', 'status_tahap' => 'wawancara', 'persentase_match' => 92, 'catatan' => 'Jadwal wawancara 28 September.'],
            ['id_pipeline' => 3, 'id_siswa' => 2, 'id_lowongan' => 2, 'nama_siswa' => 'Dewi Lestari', 'kategori_disabilitas' => 'Tuna Grahita Ringan', 'nama_perusahaan' => 'Konfeksi Cahaya', 'judul_posisi' => 'Operator Jahit', 'status_tahap' => 'direkomendasikan', 'persentase_match' => 78, 'catatan' => null],
            ['id_pipeline' => 4, 'id_siswa' => 6, 'id_lowongan' => 1, 'nama_siswa' => 'Nadia Putri', 'kategori_disabilitas' => 'Tuna Grahita Ringan', 'nama_perusahaan' => 'Kopi Kina Cafe', 'judul_posisi' => 'Barista Junior', 'status_tahap' => 'penawaran', 'persentase_match' => 81, 'catatan' => 'Penawaran dikirim ke orang tua.'],
        ];
    }

    public static function sekolah(): array
    {
        return [
            ['id_sekolah' => 1, 'nama_sekolah' => 'SLB Negeri 1 Bandung', 'kecamatan' => 'Cicendo', 'kota_kabupaten' => 'Kota Bandung', 'jumlah_siswa' => 6, 'jumlah_guru' => 4, 'status_verifikasi' => 'terverifikasi'],
            ['id_sekolah' => 2, 'nama_sekolah' => 'SLB Budi Mulia', 'kecamatan' => 'Cimahi Tengah', 'kota_kabupaten' => 'Kota Cimahi', 'jumlah_siswa' => 12, 'jumlah_guru' => 6, 'status_verifikasi' => 'terverifikasi'],
            ['id_sekolah' => 3, 'nama_sekolah' => 'SLB Cendekia', 'kecamatan' => 'Padalarang', 'kota_kabupaten' => 'Kab. Bandung Barat', 'jumlah_siswa' => 8, 'jumlah_guru' => 3, 'status_verifikasi' => 'menunggu'],
            ['id_sekolah' => 4, 'nama_sekolah' => 'SLB Harapan Bangsa', 'kecamatan' => 'Astana Anyar', 'kota_kabupaten' => 'Kota Bandung', 'jumlah_siswa' => 5, 'jumlah_guru' => 2, 'status_verifikasi' => 'ditolak'],
        ];
    }

    public static function modulAjar(): array
    {
        return [
            [
                'id_modul' => 1, 'id_keterampilan' => 2, 'nama_keterampilan' => 'Memasak Nasi Goreng',
                'judul_modul' => 'Modul Nasi Goreng Mandiri', 'tingkat_kesulitan' => 'dasar',
                'deskripsi' => 'Modul untuk melatih siswa memasak nasi goreng dari persiapan bahan hingga penyajian.',
                'relevansi_industri' => 'Kafe & restoran lokal',
                'langkah' => [
                    ['id_langkah' => 1, 'urutan' => 1, 'judul_langkah' => 'Persiapan Bahan', 'deskripsi' => 'Kenalkan bahan-bahan dan alat masak. Latih siswa menimbang bahan sederhana.', 'tip_guru' => 'Gunakan gambar bahan agar mudah dikenali.', 'video_url' => 'https://youtube.com/@inkluskill'],
                    ['id_langkah' => 2, 'urutan' => 2, 'judul_langkah' => 'Menyalakan Kompor & Menggoreng', 'deskripsi' => 'Latih siswa menyalakan kompor dengan aman dan menggoreng bumbu.', 'tip_guru' => 'Selalu dampingi saat berada dekat api.', 'video_url' => null],
                    ['id_langkah' => 3, 'urutan' => 3, 'judul_langkah' => 'Memasak Nasi', 'deskripsi' => 'Latih mencampur nasi dengan bumbu secara merata.', 'tip_guru' => 'Hitung bersama waktu mengaduk.'],
                    ['id_langkah' => 4, 'urutan' => 4, 'judul_langkah' => 'Penyajian & Kebersihan', 'deskripsi' => 'Latih plating sederhana dan membersihkan area masak.', 'tip_guru' => 'Kebersihan adalah bagian dari penilaian kompetensi.'],
                ],
            ],
            [
                'id_modul' => 2, 'id_keterampilan' => 1, 'nama_keterampilan' => 'Menjahit Dasar',
                'judul_modul' => 'Modul Menjahit Untuk Pemula', 'tingkat_kesulitan' => 'dasar',
                'deskripsi' => 'Pengenalan alat jahit, jahitan tangan, hingga mengoperasikan mesin jahit.',
                'relevansi_industri' => 'Konfeksi & butik',
                'langkah' => [
                    ['id_langkah' => 5, 'urutan' => 1, 'judul_langkah' => 'Mengenal Alat Jahit', 'deskripsi' => 'Perkenalkan jarum, benang, gunting, dan mesin jahit.', 'tip_guru' => 'Gunakan alat versi aman untuk latihan awal.', 'video_url' => null],
                    ['id_langkah' => 6, 'urutan' => 2, 'judul_langkah' => 'Jahitan Tangan Dasar', 'deskripsi' => 'Latih jahitan lurus dan tepi pada kain perca.', 'tip_guru' => 'Mulai dari kain yang tidak mudah berjus.'],
                    ['id_langkah' => 7, 'urutan' => 3, 'judul_langkah' => 'Mengoperasikan Mesin Jahit', 'deskripsi' => 'Latih mengatur kecepatan mesin dan menjahit garis lurus.', 'tip_guru' => 'Awasi kaki siswa pada pedal.'],
                ],
            ],
            [
                'id_modul' => 3, 'id_keterampilan' => 3, 'nama_keterampilan' => 'Barista Dasar',
                'judul_modul' => 'Modul Barista Kafe Sederhana', 'tingkat_kesulitan' => 'menengah',
                'deskripsi' => 'Melatih siswa menyeduh kopi manual dan menyajikan minuman ke pelanggan.',
                'relevansi_industri' => 'Kafe & kedai kopi',
                'langkah' => [
                    ['id_langkah' => 8, 'urutan' => 1, 'judul_langkah' => 'Mengenal Biji & Alat Seduh', 'deskripsi' => 'Kenalkan jenis biji kopi dan alat manual brew.', 'tip_guru' => 'Ajak siswa mencium aroma biji sangrai.', 'video_url' => 'https://youtube.com/@inkluskill'],
                    ['id_langkah' => 9, 'urutan' => 2, 'judul_langkah' => 'Menyeduh Kopi Manual', 'deskripsi' => 'Latih takaran kopi, air, dan waktu seduh.', 'tip_guru' => 'Gunakan timbangan digital sederhana.'],
                    ['id_langkah' => 10, 'urutan' => 3, 'judul_langkah' => 'Melayani Pelanggan', 'deskripsi' => 'Latih sapaan ramah dan penyajian pesanan.', 'tip_guru' => 'Role play sederhana sangat membantu.'],
                ],
            ],
            [
                'id_modul' => 4, 'id_keterampilan' => 4, 'nama_keterampilan' => 'Merawat Tanaman',
                'judul_modul' => 'Modul Berkebun Mandiri', 'tingkat_kesulitan' => 'dasar',
                'deskripsi' => 'Menyiram, memupuk, dan memindahkan tanaman dengan mandiri.',
                'relevansi_industri' => 'Nursery & agribisnis',
                'langkah' => [
                    ['id_langkah' => 11, 'urutan' => 1, 'judul_langkah' => 'Menyiram Tanaman', 'deskripsi' => 'Latih jumlah air yang tepat untuk tiap jenis tanaman.', 'tip_guru' => 'Buat jadwal harian bergambar.', 'video_url' => null],
                    ['id_langkah' => 12, 'urutan' => 2, 'judul_langkah' => 'Memindahkan Tanaman', 'deskripsi' => 'Latih memindahkan bibi ke pot yang lebih besar.', 'tip_guru' => 'Pilih tanaman yang kuat seperti lidah mertua.'],
                ],
            ],
            [
                'id_modul' => 5, 'id_keterampilan' => 6, 'nama_keterampilan' => 'Kerajinan Makrame',
                'judul_modul' => 'Modul Makrame Gantungan Pot', 'tingkat_kesulitan' => 'lanjut',
                'deskripsi' => 'Membuat gantungan pot tali makrame dari pola dasar hingga produk jadi.',
                'relevansi_industri' => 'Toko kriya & marketplace',
                'langkah' => [
                    ['id_langkah' => 13, 'urutan' => 1, 'judul_langkah' => 'Simpul Dasar Makrame', 'deskripsi' => 'Latih simpul kuat dan simpul spiral.', 'tip_guru' => 'Gunakan tali tebal untuk latihan.', 'video_url' => null],
                    ['id_langkah' => 14, 'urutan' => 2, 'judul_langkah' => 'Menyusun Pola', 'deskripsi' => 'Latih mengikuti pola gantungan pot sederhana.', 'tip_guru' => 'Warnai pola agar mudah diikuti.'],
                    ['id_langkah' => 15, 'urutan' => 3, 'judul_langkah' => 'Finishing Produk', 'deskripsi' => 'Rapikan ujung tali dan pasang pot.', 'tip_guru' => 'Dorong siswa memfoto produknya.'],
                ],
            ],
        ];
    }

    public static function jalurKemandirian(): array
    {
        return [
            ['id_keterampilan' => 2, 'nama_keterampilan' => 'Memasak Nasi Goreng', 'kategori' => 'Kuliner', 'jumlah_sesi' => 12, 'level_max' => 'mahir'],
            ['id_keterampilan' => 3, 'nama_keterampilan' => 'Barista Dasar', 'kategori' => 'Kuliner', 'jumlah_sesi' => 6, 'level_max' => 'dasar'],
            ['id_keterampilan' => 6, 'nama_keterampilan' => 'Kerajinan Makrame', 'kategori' => 'Seni Kriya', 'jumlah_sesi' => 4, 'level_max' => 'belum'],
            ['id_keterampilan' => 4, 'nama_keterampilan' => 'Merawat Tanaman', 'kategori' => 'Agribisnis', 'jumlah_sesi' => 8, 'level_max' => 'ahli'],
        ];
    }

    public static function notifikasiGuru(): array
    {
        return [
            ['id_notif' => 1, 'judul' => 'Pengajuan disetujui', 'pesan' => 'Pengajuan Ahmad Fauzi telah diterima dinas.', 'is_read' => false],
            ['id_notif' => 2, 'judul' => 'Reminder validasi', 'pesan' => 'Ada 3 log aktivitas menunggu validasi.', 'is_read' => false],
            ['id_notif' => 3, 'judul' => 'Modul baru tersedia', 'pesan' => 'Modul Barista Kafe Sederhana telah ditambahkan.', 'is_read' => true],
        ];
    }

    public static function notifikasiDinas(): array
    {
        return [
            ['id_notif' => 1, 'judul' => 'Pengajuan baru', 'pesan' => 'Dewi Lestari diajukan oleh Rina Kartika.', 'is_read' => false],
            ['id_notif' => 2, 'judul' => 'Pipeline update', 'pesan' => 'Rizky Ramadhan masuk tahap wawancara.', 'is_read' => false],
            ['id_notif' => 3, 'judul' => 'Mitra baru terverifikasi', 'pesan' => 'Nursery Hijau Asri siap menerima penyaluran.', 'is_read' => true],
        ];
    }

    public static function logSistem(): array
    {
        return [
            ['id_log_sistem' => 1, 'level' => 'info', 'deskripsi' => 'Backup otomatis database berhasil dijalankan.', 'aktor' => 'SYSTEM', 'created_at' => '2026-09-26 07:30:00'],
            ['id_log_sistem' => 2, 'level' => 'warning', 'deskripsi' => 'Penggunaan memory server melewati 80%.', 'aktor' => 'SYSTEM', 'created_at' => '2026-09-26 12:14:00'],
            ['id_log_sistem' => 3, 'level' => 'info', 'deskripsi' => 'Pengajuan baru dibuat oleh Rina Kartika.', 'aktor' => 'guru.rina', 'created_at' => '2026-09-25 08:15:00'],
            ['id_log_sistem' => 4, 'level' => 'error', 'deskripsi' => 'Gagal mengirim email notifikasi ke mitra Kriya Nusantara.', 'aktor' => 'SYSTEM', 'created_at' => '2026-09-25 10:02:00'],
            ['id_log_sistem' => 5, 'level' => 'info', 'deskripsi' => 'Pipeline Ahmad Fauzi diperbarui menjadi diterima.', 'aktor' => 'dinas.andi', 'created_at' => '2026-09-24 15:41:00'],
            ['id_log_sistem' => 6, 'level' => 'info', 'deskripsi' => 'Login berhasil untuk dinas.andi.', 'aktor' => 'dinas.andi', 'created_at' => '2026-09-24 08:00:00'],
        ];
    }

    public static function dashboardGuru(array $siswa, array $log): array
    {
        $logMenunggu = array_filter($log, fn ($l) => $l['status_validasi'] === 'menunggu');

        return [
            'total_siswa' => count($siswa),
            'total_sesi' => count($log),
            'menunggu_validasi' => count($logMenunggu),
            'total_pengajuan' => count(self::pengajuan()),
        ];
    }

    public static function dashboardDinas(): array
    {
        $pipeline = self::pipeline();

        return [
            'total_siswa' => count(self::siswa()),
            'total_sekolah' => count(self::sekolah()),
            'total_mitra' => count(array_filter(self::mitra(), fn ($m) => $m['status'] === 'aktif')),
            'pengajuan_baru' => count(array_filter(self::pengajuan(), fn ($p) => $p['status'] === 'diajukan')),
            'pipeline_proses' => count(array_filter($pipeline, fn ($p) => ! in_array($p['status_tahap'], ['diterima', 'ditolak'], true))),
            'pipeline_diterima' => count(array_filter($pipeline, fn ($p) => $p['status_tahap'] === 'diterima')),
        ];
    }

    public static function publicStats(): array
    {
        return [
            'total_sekolah' => 24,
            'total_peserta' => 156,
            'total_pelatihan' => 8,
            'total_lowongan' => 12,
        ];
    }
}
