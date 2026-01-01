<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Update/Create Tabel Users (Menyesuaikan Role)
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nik')->nullable(); // <--- TAMBAH INI
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('role', ['dokter', 'staff', 'pasien'])->default('pasien');
        $table->text('alamat')->nullable();
        $table->string('no_hp')->nullable();
        $table->timestamps();
    });

        // 2. Tabel Poli
        Schema::create('polis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_poli');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Dokter (Menghubungkan User dengan Poli)
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
            $table->string('sip')->nullable(); // Surat Izin Praktek
            $table->timestamps();
        });

        // 4. Tabel Jadwal Dokter (Fitur Baru)
        Schema::create('jadwal_dokters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // 5. Tabel Rekam Medis / Booking
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
            
            $table->date('tgl_periksa');
            $table->string('no_antrean')->nullable(); 
            
            $table->text('keluhan_awal');
            $table->text('diagnosa')->nullable();
            $table->text('resep_obat')->nullable();
            
            $table->enum('status', ['booking', 'menunggu', 'dipanggil', 'diperiksa', 'selesai','request_batal', 'batal'])
                  ->default('booking');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekam_medis');
        Schema::dropIfExists('jadwal_dokters');
        Schema::dropIfExists('dokters');
        Schema::dropIfExists('polis');
        Schema::dropIfExists('users');
    }
};