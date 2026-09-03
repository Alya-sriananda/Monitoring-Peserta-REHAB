<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiSipp extends Model
{
    protected $fillable = [
        'peserta_id', 'user_id', 'tanggal_cek', 'terdaftar_rehab',
        'tanggal_daftar_rehab', 'jumlah_peserta_sipp', 'tagihan_bulan_berjalan',
        'tagihan_sebelum_bulan_berjalan', 'status_pembayaran_bulan_berjalan', 'catatan'
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
