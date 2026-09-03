<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Actions\ImportBatchAction;
use Illuminate\Support\Facades\Storage;
use Exception;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('batch.index', compact('batches'));
    }

    public function store(Request $request, ImportBatchAction $action)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:20480', // max 20MB
        ]);

        $file = $request->file('file');
        $path = $file->store('private/batches');

        try {
            $batch = $action->execute(Storage::path($path), $file->getClientOriginalName(), auth()->id());
            return redirect()->route('batch.index')->with('success', "Batch berhasil diimport. {$batch->total_peserta_baru} peserta baru, {$batch->total_valid} valid.");
        } catch (Exception $e) {
            Storage::delete($path);
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function show(Batch $batch)
    {
        // Redirect to Peserta page with batch filter, maintaining context
        return redirect()->route('peserta.index', ['batch' => $batch->id]);
    }
}
