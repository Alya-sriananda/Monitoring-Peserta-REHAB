<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Peserta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeserta = Peserta::count();
        $totalBatch = Batch::count();
        
        // Priority Outstanding: Participants with SIPP Verification, still have debt
        $priorityOutstanding = Peserta::whereHas('verifikasi_sipps', function ($q) {
            $q->whereRaw('(tagihan_bulan_berjalan + tagihan_sebelum_bulan_berjalan) > 0')
              ->where('terdaftar_rehab', true);
        })->with(['verifikasi_sipps' => function($q) {
            $q->latest('tanggal_cek');
        }])->take(10)->get();

        return view('dashboard', compact('totalPeserta', 'totalBatch', 'priorityOutstanding'));
    }
}
