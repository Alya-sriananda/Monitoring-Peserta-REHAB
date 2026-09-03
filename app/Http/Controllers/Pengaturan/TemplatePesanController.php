<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\TemplatePesan;
use Illuminate\Http\Request;

class TemplatePesanController extends Controller
{
    public function index()
    {
        $templates = TemplatePesan::orderBy('created_at', 'desc')->get();
        return view('pengaturan.template-pesan.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'isi_template' => 'required|string',
        ]);

        TemplatePesan::create($request->only('nama_template', 'isi_template'));
        return back()->with('success', 'Template pesan berhasil ditambahkan.');
    }

    public function update(Request $request, TemplatePesan $template_pesan)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'isi_template' => 'required|string',
            'aktif' => 'boolean'
        ]);

        $template_pesan->update([
            'nama_template' => $request->nama_template,
            'isi_template' => $request->isi_template,
            'aktif' => $request->has('aktif')
        ]);
        return back()->with('success', 'Template pesan berhasil diupdate.');
    }

    public function destroy(TemplatePesan $template_pesan)
    {
        $template_pesan->delete();
        return back()->with('success', 'Template pesan berhasil dihapus.');
    }
}
