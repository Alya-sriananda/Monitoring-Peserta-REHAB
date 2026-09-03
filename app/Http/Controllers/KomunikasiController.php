<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\TemplatePesan;
use App\Services\MessageGeneratorService;
use Illuminate\Http\Request;

class KomunikasiController extends Controller
{
    public function generate(Request $request, Peserta $peserta, MessageGeneratorService $generator)
    {
        $request->validate([
            'template_id' => 'required|exists:template_pesans,id'
        ]);

        $template = TemplatePesan::find($request->template_id);
        $message = $generator->generate($peserta, $template);

        return response()->json(['message' => $message]);
    }

    public function store(Request $request, Peserta $peserta)
    {
        $request->validate([
            'status' => 'required|string',
            'catatan' => 'nullable|string',
            'template_id' => 'nullable|exists:template_pesans,id',
            'pesan' => 'nullable|string'
        ]);

        $template = $request->template_id ? TemplatePesan::find($request->template_id) : null;

        $peserta->komunikasis()->create([
            'user_id' => auth()->id(),
            'no_hp' => $peserta->no_hp,
            'template' => $template ? $template->nama_template : null,
            'pesan' => $request->pesan,
            'status' => $request->status,
            'tanggal_dihubungi' => now(),
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Hasil komunikasi berhasil dicatat.');
    }
}
