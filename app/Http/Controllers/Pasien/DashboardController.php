<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // <--- WAJIB ADA
use App\Models\RekamMedis;
use App\Models\Poli;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $polis = Poli::all();

        $query = RekamMedis::with(['poli', 'dokter.user'])
                    ->where('pasien_id', Auth::id());

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tgl_periksa', $request->date);
        }

        if ($request->has('poli') && $request->poli != '') {
            $query->where('poli_id', $request->poli);
        }

        $riwayats = $query->orderBy('tgl_periksa', 'desc')->get();

        return view('pasien.dashboard', compact('riwayats', 'polis'));
    }
}