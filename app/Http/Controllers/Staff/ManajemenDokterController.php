<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Support\Facades\Hash;

class ManajemenDokterController extends Controller
{
    // 1. Tampilkan Daftar Dokter
    public function index()
    {
        $dokters = Dokter::with(['user', 'poli'])->get();
        return view('staff.dokter.index', compact('dokters'));
    }

    // 2. Tampilkan Form Tambah Dokter
    public function create()
    {
        $polis = Poli::all();
        return view('staff.dokter.create', compact('polis'));
    }

    // 3. Simpan Dokter Baru
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'poli_id' => 'required',
            'sip' => 'required',
            'nik' => 'required|numeric',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        // A. Buat Akun User (Role Dokter)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        // B. Hubungkan ke Tabel Dokter
        Dokter::create([
            'user_id' => $user->id,
            'poli_id' => $request->poli_id,
            'sip' => $request->sip
        ]);

        return redirect()->route('staff.dokter.index')->with('success', 'Dokter berhasil ditambahkan!');
    }

    // 4. Hapus Dokter
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        // Hapus usernya juga (otomatis dokter terhapus karena cascade)
        $dokter->user->delete(); 
        
        return back()->with('success', 'Data dokter berhasil dihapus.');
    }
}