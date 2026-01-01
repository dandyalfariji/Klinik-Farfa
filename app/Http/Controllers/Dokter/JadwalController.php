<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalDokter;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // Tampilkan Halaman Jadwal
    public function index()
    {
        // Pastikan user yang login punya data dokter
        $dokter = Auth::user()->dokter;
        
        if(!$dokter) {
            return back()->with('error', 'Akun Anda tidak terhubung dengan data dokter.');
        }

        // Ambil jadwal dokter tersebut
        $jadwals = JadwalDokter::where('dokter_id', $dokter->id)->get();

        return view('dokter.jadwal.index', compact('jadwals'));
    }

    // Simpan Jadwal Baru
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $dokter = Auth::user()->dokter;

        JadwalDokter::create([
            'dokter_id' => $dokter->id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'aktif' => true // <--- Set default aktif
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Hapus Jadwal
    public function destroy($id)
    {
        $jadwal = JadwalDokter::findOrFail($id);
        
        // Cek kepemilikan (Security)
        if($jadwal->dokter_id == Auth::user()->dokter->id) {
            $jadwal->delete();
            return back()->with('success', 'Jadwal dihapus.');
        }
        
        return back()->with('error', 'Anda tidak berhak menghapus jadwal ini.');
    }
}