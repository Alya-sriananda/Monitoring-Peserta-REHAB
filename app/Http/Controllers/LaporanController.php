<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PesertaExport;
use App\Models\Batch;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $batches = Batch::orderBy('created_at', 'desc')->get();
        return view('laporan.index', compact('batches'));
    }

    public function export(Request $request)
    {
        $batchId = $request->batch_id;
        $batch = $batchId ? Batch::find($batchId) : null;
        $fileName = 'laporan_peserta_' . ($batch ? 'batch_'.$batch->id : 'semua') . '_' . date('YmdHis') . '.xlsx';
        
        return Excel::download(new PesertaExport($batchId), $fileName);
    }
}
