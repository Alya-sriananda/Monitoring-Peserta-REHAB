<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'tanggal_data', 'nama_file', 'jumlah_data', 'is_baseline',
        'status_import', 'created_by', 'total_valid', 'total_invalid',
        'total_duplicate', 'total_peserta_baru', 'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pesertas()
    {
        return $this->belongsToMany(Peserta::class, 'peserta_batches')
                    ->withPivot('status_proses', 'snapshot')
                    ->withTimestamps();
    }
}
