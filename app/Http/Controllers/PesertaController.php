<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Batch;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::query();

        if ($request->filled('batch')) {
            $query->whereHas('batches', function ($q) use ($request) {
                $q->where('batches.id', $request->batch);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('noka', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $pesertas = $query->orderBy('updated_at', 'desc')->paginate(15)->withQueryString();
        $batchAktif = $request->filled('batch') ? Batch::find($request->batch) : null;

        return view('peserta.index', compact('pesertas', 'batchAktif'));
    }

    public function show(Peserta $peserta)
    {
        $peserta->load(['verifikasi_sipps.user', 'komunikasis.user', 'batches']);
        $templates = \App\Models\TemplatePesan::where('aktif', true)->get();
        return view('peserta.show', compact('peserta', 'templates'));
    }
}
