<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeriksaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Validasi Dokter
        $dokter = Auth::user()->dokter;
        
        if (!$dokter) {
            abort(403, 'Akun Anda bukan akun Dokter yang valid.');
        }

        $dokterId = $dokter->id;
        
        // 2. Handle Filter Tanggal (History) & Status
        $tanggal = $request->input('date', Carbon::today()->format('Y-m-d'));
        $statusFilter = $request->input('status', 'all'); // Default tampilkan semua

        // 3. Query Dasar
        $query = RekamMedis::where('dokter_id', $dokterId)
            ->whereDate('tgl_periksa', $tanggal);

        // 4. Logika Filter Status
        if ($statusFilter !== 'all') {
            // Jika user memilih filter spesifik (misal: hanya 'menunggu' atau 'selesai')
            $query->where('status', $statusFilter);
        } else {
            // Jika 'all', tetap batasi status yang relevan agar data sampah tidak masuk
            $query->whereIn('status', ['booking', 'menunggu', 'dipanggil', 'diperiksa', 'selesai']);
        }

        // 5. Eksekusi Query dengan Sorting
        $antreans = $query
            // Priority Sorting: Dipanggil -> Diperiksa -> Menunggu -> Booking -> Selesai
            ->orderByRaw("FIELD(status, 'dipanggil', 'diperiksa', 'menunggu', 'booking', 'selesai')")
            // Secondary Sorting: Berdasarkan Nomor Antrean (Agar urut 1, 2, 3...)
            ->orderBy('no_antrean', 'asc')
            ->get();

        // Hitung ringkasan untuk badge di UI
        $counts = [
            'menunggu' => RekamMedis::where('dokter_id', $dokterId)->whereDate('tgl_periksa', $tanggal)->where('status', 'menunggu')->count(),
            'dipanggil' => RekamMedis::where('dokter_id', $dokterId)->whereDate('tgl_periksa', $tanggal)->where('status', 'dipanggil')->count(),
            'selesai' => RekamMedis::where('dokter_id', $dokterId)->whereDate('tgl_periksa', $tanggal)->where('status', 'selesai')->count(),
        ];

        return view('dokter.periksa.index', compact('antreans', 'tanggal', 'statusFilter', 'counts'));
    }

    // --- Method Panggil Pasien ---
    public function panggil($id)
    {
        $rm = RekamMedis::findOrFail($id);
        
        // Validasi: Jangan panggil jika sudah selesai
        if($rm->status == 'selesai') {
            return back()->with('error', 'Pasien ini sudah selesai diperiksa.');
        }

        $rm->update(['status' => 'dipanggil']);
        return back()->with('success', 'Pasien No ' . $rm->no_antrean . ' dipanggil masuk.');
    }

    // --- Method Edit (Form Periksa) ---
    public function edit($id)
    {
        $rm = RekamMedis::findOrFail($id);
        
        // Ubah status ke 'diperiksa' saat dokter membuka form, kecuali jika sudah selesai
        if($rm->status == 'dipanggil' || $rm->status == 'menunggu') {
            $rm->update(['status' => 'diperiksa']);
        }
        
        return view('dokter.periksa.edit', compact('rm'));
    }

    // --- Method Update (Simpan Diagnosa) ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required',
            'resep_obat' => 'required',
        ]);

        $rm = RekamMedis::findOrFail($id);
        $rm->update([
            'diagnosa' => $request->diagnosa,
            'resep_obat' => $request->resep_obat,
            'status' => 'selesai'
        ]);

        return redirect()->route('dokter.periksa.index')->with('success', 'Pemeriksaan selesai.');
    }
}