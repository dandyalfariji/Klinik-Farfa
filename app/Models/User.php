<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nik',       // <--- WAJIB ADA
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',    // <--- WAJIB ADA
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke Dokter (Opsional jika user adalah dokter)
    public function dokter() {
        return $this->hasOne(Dokter::class);
    }
}