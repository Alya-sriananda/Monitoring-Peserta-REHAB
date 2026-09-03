<?php

namespace App\Services;

use App\Models\Peserta;
use App\Models\TemplatePesan;

class MessageGeneratorService
{
    public function generate(Peserta $peserta, TemplatePesan $template)
    {
        $message = $template->isi_template;
        
        $verifikasi = $peserta->verifikasi_sipps()->latest('tanggal_cek')->first();
        
        $tagihan_sebelumnya = $verifikasi ? $verifikasi->tagihan_sebelum_bulan_berjalan : 0;
        $tagihan_berjalan = $verifikasi ? $verifikasi->tagihan_bulan_berjalan : 0;
        $sisa_tunggakan = $tagihan_sebelumnya + $tagihan_berjalan;

        $variables = [
            '{name}' => $peserta->nama,
            '{noka}' => $peserta->noka,
            '{no_hp}' => $peserta->no_hp,
            '{email}' => $peserta->email ?? '-',
            '{tanggal_daftar_rehab}' => $verifikasi && $verifikasi->tanggal_daftar_rehab ? $verifikasi->tanggal_daftar_rehab : '-',
            '{jumlah_peserta_sipp}' => $verifikasi ? $verifikasi->jumlah_peserta_sipp : 1,
            '{tagihan_sebelumnya}' => number_format($tagihan_sebelumnya, 0, ',', '.'),
            '{tagihan_berjalan}' => number_format($tagihan_berjalan, 0, ',', '.'),
            '{sisa_tunggakan}' => number_format($sisa_tunggakan, 0, ',', '.'),
        ];

        foreach ($variables as $key => $value) {
            $message = str_replace($key, $value, $message);
        }

        return $message;
    }
}
