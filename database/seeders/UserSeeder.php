<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. DATA MASTER POLI
        // ==========================================
        $poliUmum = Poli::create(['nama_poli' => 'Poli Umum', 'deskripsi' => 'Layanan kesehatan dasar']);
        $poliGigi = Poli::create(['nama_poli' => 'Poli Gigi', 'deskripsi' => 'Perawatan gigi dan mulut']);
        $poliAnak = Poli::create(['nama_poli' => 'Poli Anak', 'deskripsi' => 'Spesialis kesehatan anak']);

        // ==========================================
        // 2. AKUN STAFF (RESEPSIONIS)
        // ==========================================
        User::create([
            'name' => 'Siti Resepsionis',
            'email' => 'staff@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'nik' => '3201010101010001',
            'no_hp' => '081234567890',
            'alamat' => 'Meja Depan Klinik Farfa'
        ]);

        // ==========================================
        // 3. DOKTER & JADWAL
        // ==========================================
        
        // --- Dokter Umum 1 ---
        $drBudi = User::create([
            'name' => 'dr. Budi Santoso',
            'email' => 'budi@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'nik' => '3201010101010002',
            'no_hp' => '081299990001',
            'alamat' => 'Jl. Merpati No. 1'
        ]);
        $dokBudi = Dokter::create(['user_id' => $drBudi->id, 'poli_id' => $poliUmum->id, 'sip' => 'SIP.111.222']);
        // Jadwal dr Budi
        JadwalDokter::create(['dokter_id' => $dokBudi->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'aktif' => true]);
        JadwalDokter::create(['dokter_id' => $dokBudi->id, 'hari' => 'Rabu', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00', 'aktif' => true]);

        // --- Dokter Umum 2 ---
        $drSari = User::create([
            'name' => 'dr. Sari Indah',
            'email' => 'sari@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'nik' => '3201010101010003',
            'no_hp' => '081299990002',
            'alamat' => 'Jl. Kenari No. 5'
        ]);
        $dokSari = Dokter::create(['user_id' => $drSari->id, 'poli_id' => $poliUmum->id, 'sip' => 'SIP.333.444']);
        JadwalDokter::create(['dokter_id' => $dokSari->id, 'hari' => 'Selasa', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'aktif' => true]);
        JadwalDokter::create(['dokter_id' => $dokSari->id, 'hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '17:00', 'aktif' => true]);

        // --- Dokter Gigi ---
        $drgLina = User::create([
            'name' => 'drg. Lina Marlina',
            'email' => 'lina@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'nik' => '3201010101010004',
            'no_hp' => '081299990003',
            'alamat' => 'Jl. Mawar Melati No. 10'
        ]);
        $dokLina = Dokter::create(['user_id' => $drgLina->id, 'poli_id' => $poliGigi->id, 'sip' => 'SIP.555.666']);
        JadwalDokter::create(['dokter_id' => $dokLina->id, 'hari' => 'Senin', 'jam_mulai' => '15:00', 'jam_selesai' => '20:00', 'aktif' => true]);
        JadwalDokter::create(['dokter_id' => $dokLina->id, 'hari' => 'Jumat', 'jam_mulai' => '15:00', 'jam_selesai' => '20:00', 'aktif' => true]);

        // --- Dokter Anak ---
        $drAnak = User::create([
            'name' => 'dr. Ceria Wibowo, Sp.A',
            'email' => 'ceria@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'nik' => '3201010101010005',
            'no_hp' => '081299990004',
            'alamat' => 'Jl. Taman Bermain No. 8'
        ]);
        $dokAnak = Dokter::create(['user_id' => $drAnak->id, 'poli_id' => $poliAnak->id, 'sip' => 'SIP.777.888']);
        JadwalDokter::create(['dokter_id' => $dokAnak->id, 'hari' => 'Sabtu', 'jam_mulai' => '09:00', 'jam_selesai' => '14:00', 'aktif' => true]);

        // ==========================================
        // 4. PASIEN
        // ==========================================
        $p1 = User::create([
            'name' => 'Andi Pasien',
            'email' => 'andi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'nik' => '3201010101010101',
            'no_hp' => '085612345678',
            'alamat' => 'Komp. Griya Indah Blok A1'
        ]);

        $p2 = User::create([
            'name' => 'Budi Sakit Gigi',
            'email' => 'budi_gigi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'nik' => '3201010101010102',
            'no_hp' => '085687654321',
            'alamat' => 'Jl. Pahlawan No. 45'
        ]);

        $p3 = User::create([
            'name' => 'Citra Lestari',
            'email' => 'citra@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'nik' => '3201010101010103',
            'no_hp' => '081344556677',
            'alamat' => 'Apartemen Sentosa Lt. 5'
        ]);

        // ==========================================
        // 5. RIWAYAT MEDIS (DUMMY DATA)
        // ==========================================
        
        // Kasus 1: Selesai (Andi ke dr. Budi) - Tanggal kemarin
        RekamMedis::create([
            'pasien_id' => $p1->id,
            'dokter_id' => $dokBudi->id,
            'poli_id' => $poliUmum->id,
            'tgl_periksa' => Carbon::yesterday(),
            'no_antrean' => 'ANT-001',
            'keluhan_awal' => 'Demam tinggi dan pusing sejak 2 hari',
            'diagnosa' => 'Febris (Demam biasa)',
            'resep_obat' => '- Paracetamol 500mg (3x1)\n- Vitamin C (1x1)',
            'status' => 'selesai'
        ]);

        // Kasus 2: Booking Hari Ini (Citra ke dr. Sari)
        RekamMedis::create([
            'pasien_id' => $p3->id,
            'dokter_id' => $dokSari->id,
            'poli_id' => $poliUmum->id,
            'tgl_periksa' => Carbon::today(),
            'no_antrean' => 'ANT-102',
            'keluhan_awal' => 'Batuk kering',
            'status' => 'booking' // Belum datang
        ]);

        // Kasus 3: Menunggu di Klinik Hari Ini (Budi ke drg. Lina)
        RekamMedis::create([
            'pasien_id' => $p2->id,
            'dokter_id' => $dokLina->id,
            'poli_id' => $poliGigi->id,
            'tgl_periksa' => Carbon::today(),
            'no_antrean' => 'ANT-103',
            'keluhan_awal' => 'Gigi geraham belakang sakit nyut-nyutan',
            'status' => 'menunggu' // Sudah check-in
        ]);
        
        // Kasus 4: Selesai Bulan Lalu (Andi ke dr. Anak - misal bawa anaknya)
        RekamMedis::create([
            'pasien_id' => $p1->id,
            'dokter_id' => $dokAnak->id,
            'poli_id' => $poliAnak->id,
            'tgl_periksa' => Carbon::now()->subMonth(),
            'no_antrean' => 'ANT-OLD-99',
            'keluhan_awal' => 'Imunisasi Campak',
            'diagnosa' => 'Sehat',
            'resep_obat' => '- Vitamin Penambah Nafsu Makan',
            'status' => 'selesai'
        ]);
    }
}
