<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekamMedis;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('date', Carbon::today()->format('Y-m-d'));

        // 1. AMBIL SEMUA REQUEST BATAL (Tanpa filter tanggal agar tidak terlewat)
        $requestBatal = RekamMedis::with(['pasien', 'dokter'])
            ->where('status', 'request_batal')
            ->orderBy('updated_at', 'asc')
            ->get();

        // 2. Booking PADA TANGGAL TERSEBUT
        $bookingsToday = RekamMedis::with(['pasien', 'dokter', 'poli'])
            ->whereDate('tgl_periksa', $tanggal)
            ->where('status', 'booking')
            ->orderBy('created_at', 'asc')
            ->get();

        // 3. Antrean Aktif / Riwayat
        $antreans = RekamMedis::with(['pasien', 'dokter'])
            ->whereDate('tgl_periksa', $tanggal)
            ->whereIn('status', ['menunggu', 'dipanggil', 'diperiksa', 'selesai', 'batal'])
            ->orderByRaw("FIELD(status, 'dipanggil', 'diperiksa', 'menunggu', 'selesai', 'batal')")
            ->get();

        return view('staff.kunjungan.index', compact('bookingsToday', 'antreans', 'tanggal', 'requestBatal'));
    }

    public function checkIn($id)
    {
        $rm = RekamMedis::findOrFail($id);
        $rm->update(['status' => 'menunggu']);
        return back()->with('success', 'Pasien berhasil Check-in.');
    }

    // PERSETUJUAN BATAL
    public function approveBatal($id)
    {
        $rm = RekamMedis::findOrFail($id);
        $rm->update(['status' => 'batal']);
        return back()->with('success', 'Pembatalan disetujui.');
    }

    public function rejectBatal($id)
    {
        $rm = RekamMedis::findOrFail($id);
        $rm->update(['status' => 'booking']);
        return back()->with('success', 'Pembatalan ditolak. Status kembali ke Booking.');
    }

    public function forceCancel($id)
    {
        $rm = RekamMedis::findOrFail($id);
        $rm->update(['status' => 'batal']);
        return back()->with('success', 'Booking dibatalkan.');
    }
}