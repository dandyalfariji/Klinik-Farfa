<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $polis = Poli::all();
        return view('pasien.booking.create', compact('polis'));
    }

    public function getDoktersByPoli($poliId)
    {
        $dokters = Dokter::with(['user', 'jadwals' => function($q) {
            $q->where('aktif', true);
        }])->where('poli_id', $poliId)->get();

        return response()->json($dokters);
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'dokter_id' => 'required|exists:dokters,id',
            'tgl_periksa' => 'required|date|after_or_equal:today',
            'keluhan_awal' => 'required|string|max:500',
        ]);

        $antrean = 'ANT-' . time(); 

        RekamMedis::create([
            'pasien_id' => Auth::id(),
            'poli_id' => $request->poli_id,
            'dokter_id' => $request->dokter_id,
            'tgl_periksa' => $request->tgl_periksa,
            'keluhan_awal' => $request->keluhan_awal,
            'no_antrean' => $antrean,
            'status' => 'booking'
        ]);

        return redirect()->route('pasien.dashboard')->with('success', 'Booking berhasil!');
    }

    public function requestBatal($id)
    {
        $rm = RekamMedis::where('id', $id)
                ->where('pasien_id', Auth::id())
                ->firstOrFail();

        if(in_array($rm->status, ['booking', 'menunggu'])) {
            $rm->update(['status' => 'request_batal']);
            return back()->with('success', 'Permintaan pembatalan dikirim. Menunggu persetujuan resepsionis.');
        }

        return back()->with('error', 'Status kunjungan tidak valid untuk pembatalan.');
    }
}