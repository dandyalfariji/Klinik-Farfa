<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\RekamMedis;
use App\Models\JadwalDokter;

// Controller Auth
use App\Http\Controllers\AuthController;

// Controller Pasien
use App\Http\Controllers\Pasien\BookingController;
use App\Http\Controllers\Pasien\DashboardController; // <--- PENTING: Tambahkan ini

// Controller Dokter
use App\Http\Controllers\Dokter\JadwalController;
use App\Http\Controllers\Dokter\PeriksaController;

// Controller Staff
use App\Http\Controllers\Staff\KunjunganController;
use App\Http\Controllers\Staff\ManajemenDokterController;

/*
|--------------------------------------------------------------------------
| HOMEPAGE (Jadwal Dokter)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Ambil semua jadwal dokter yang aktif, urutkan berdasarkan Hari
    $jadwals = JadwalDokter::with(['dokter.user', 'dokter.poli'])
                ->where('aktif', true)
                ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
                ->orderBy('jam_mulai')
                ->get();
                
    return view('welcome', compact('jadwals'));
})->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECTOR
|--------------------------------------------------------------------------
| Route ini hanya bertugas mengarahkan user ke dashboard sesuai role
*/
Route::get('/dashboard', function () {
    if (!Auth::check()) return redirect()->route('login');
    
    $role = Auth::user()->role;
    
    if ($role == 'pasien') return redirect()->route('pasien.dashboard');
    if ($role == 'dokter') return redirect()->route('dokter.periksa.index');
    if ($role == 'staff')  return redirect()->route('staff.dashboard');
    
    Auth::logout();
    return redirect('/login');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| AREA PASIEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pasien'])->group(function () {
    
    // PERBAIKAN: Menggunakan DashboardController agar filter Poli & Tanggal berfungsi
    Route::get('/pasien/dashboard', [DashboardController::class, 'index'])->name('pasien.dashboard');

    // Route Booking
    Route::get('/booking/baru', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::put('/booking/{id}/batal', [BookingController::class, 'requestBatal'])->name('booking.batal');
    
    // API untuk AJAX dropdown dokter
    Route::get('/api/dokters/{poli}', [BookingController::class, 'getDoktersByPoli']);
});

/*
|--------------------------------------------------------------------------
| AREA DOKTER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    
    // Manajemen Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    
    // Pemeriksaan Pasien
    Route::get('/periksa', [PeriksaController::class, 'index'])->name('periksa.index');
    Route::get('/periksa/{id}', [PeriksaController::class, 'edit'])->name('periksa.edit'); // Form Periksa
    Route::put('/periksa/{id}', [PeriksaController::class, 'update'])->name('periksa.update'); // Simpan Diagnosa
    
    // PERBAIKAN: Route Panggil Pasien (Untuk Tombol Kuning 'Panggil')
    Route::get('/periksa/panggil/{id}', [PeriksaController::class, 'panggil'])->name('periksa.panggil');
});

/*
|--------------------------------------------------------------------------
| AREA STAFF (RESEPSIONIS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    
    // Dashboard Staff (Antrean Hari Ini)
    Route::get('/dashboard', [KunjunganController::class, 'index'])->name('dashboard');
    Route::put('/kunjungan/{id}/checkin', [KunjunganController::class, 'checkIn'])->name('checkin');
    
    // Approval Pembatalan & Force Cancel
    Route::put('/kunjungan/{id}/approve-batal', [KunjunganController::class, 'approveBatal'])->name('approve_batal');
    Route::put('/kunjungan/{id}/reject-batal', [KunjunganController::class, 'rejectBatal'])->name('reject_batal');
    Route::put('/kunjungan/{id}/force-cancel', [KunjunganController::class, 'forceCancel'])->name('force_cancel');

    // Manajemen Data Dokter
    Route::get('/kelola-dokter', [ManajemenDokterController::class, 'index'])->name('dokter.index');
    Route::get('/kelola-dokter/tambah', [ManajemenDokterController::class, 'create'])->name('dokter.create');
    Route::post('/kelola-dokter', [ManajemenDokterController::class, 'store'])->name('dokter.store');
    Route::delete('/kelola-dokter/{id}', [ManajemenDokterController::class, 'destroy'])->name('dokter.destroy');
});