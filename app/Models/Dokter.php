<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokters';

    protected $fillable = [
        'user_id',
        'poli_id',
        'sip', // Surat Izin Praktek
    ];

    // Relasi ke User (untuk ambil nama, email)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Poli (Dokter ini di poli apa)
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    // Relasi ke Jadwal
    public function jadwals()
    {
        return $this->hasMany(JadwalDokter::class);
    }
}