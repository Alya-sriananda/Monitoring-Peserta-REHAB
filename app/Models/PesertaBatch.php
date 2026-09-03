<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaBatch extends Model
{
    protected $fillable = ['batch_id', 'peserta_id', 'status_proses', 'snapshot'];
    protected $casts = ['snapshot' => 'array'];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
