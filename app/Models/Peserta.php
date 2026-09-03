<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
        'noka', 'nama', 'no_hp', 'email', 'alamat', 'status_aktif',
        'nopendaftar', 'nopenghubung', 'startcicilan', 'endcicilan',
        'tglcicilan', 'tanggal_update_data'
    ];

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'peserta_batches')
                    ->withPivot('status_proses', 'snapshot')
                    ->withTimestamps();
    }

    public function verifikasi_sipps()
    {
        return $this->hasMany(VerifikasiSipp::class);
    }

    public function komunikasis()
    {
        return $this->hasMany(Komunikasi::class);
    }
}
