<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\VerifikasiSipp;
use Illuminate\Http\Request;

class VerifikasiSippController extends Controller
{
    public function store(Request $request, Peserta $peserta)
    {
        $request->validate([
            'terdaftar_rehab' => 'required|boolean',
            'tanggal_daftar_rehab' => 'nullable|date',
            'jumlah_peserta_sipp' => 'required|integer|min:1',
            'tagihan_bulan_berjalan' => 'required|numeric|min:0',
            'tagihan_sebelum_bulan_berjalan' => 'required|numeric|min:0',
            'status_pembayaran_bulan_berjalan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $peserta->verifikasi_sipps()->create([
            'user_id' => auth()->id(),
            'tanggal_cek' => now(),
            'terdaftar_rehab' => $request->terdaftar_rehab,
            'tanggal_daftar_rehab' => $request->tanggal_daftar_rehab,
            'jumlah_peserta_sipp' => $request->jumlah_peserta_sipp,
            'tagihan_bulan_berjalan' => $request->tagihan_bulan_berjalan,
            'tagihan_sebelum_bulan_berjalan' => $request->tagihan_sebelum_bulan_berjalan,
            'status_pembayaran_bulan_berjalan' => $request->status_pembayaran_bulan_berjalan,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Verifikasi SIPP berhasil disimpan.');
    }
}
