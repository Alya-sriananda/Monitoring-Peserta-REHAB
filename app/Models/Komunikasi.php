<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komunikasi extends Model
{
    protected $fillable = [
        'peserta_id', 'user_id', 'no_hp', 'template', 'pesan',
        'status', 'tanggal_dihubungi', 'catatan'
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
