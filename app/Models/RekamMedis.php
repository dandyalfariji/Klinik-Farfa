<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;   // <-- Tambahkan ini untuk relasi pasien
use App\Models\Dokter; // <-- Tambahkan ini
use App\Models\Poli;

class RekamMedis extends Model
{
    use HasFactory;
    
    // Pastikan nama tabel benar
    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'poli_id',
        'tgl_periksa',
        'no_antrean',
        'keluhan_awal',
        'diagnosa',
        'resep_obat',
        'status', // booking, menunggu, dipanggil, diperiksa, selesai, batal
    ];

    // Relasi ke User (sebagai Pasien)
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    // Relasi ke Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    // Relasi ke Poli
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}