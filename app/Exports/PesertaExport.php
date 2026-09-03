<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PesertaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $batchId;

    public function __construct($batchId = null)
    {
        $this->batchId = $batchId;
    }

    public function collection()
    {
        $query = Peserta::with([
            'verifikasi_sipps' => function($q) { $q->latest('tanggal_cek'); },
            'komunikasis' => function($q) { $q->latest('tanggal_dihubungi'); }
        ]);
        
        if ($this->batchId) {
            $query->whereHas('batches', function ($q) {
                $q->where('batches.id', $this->batchId);
            });
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'NOKA',
            'Nama',
            'No HP',
            'Alamat',
            'Status REHAB',
            'Tagihan Berjalan',
            'Sisa Tunggakan',
            'Terakhir Dihubungi',
            'Status Komunikasi',
            'Catatan Komunikasi',
        ];
    }

    public function map($peserta): array
    {
        $verifikasi = $peserta->verifikasi_sipps->first();
        $komunikasi = $peserta->komunikasis->first();
        
        $sisa = $verifikasi ? ($verifikasi->tagihan_sebelum_bulan_berjalan + $verifikasi->tagihan_bulan_berjalan) : 0;
        
        return [
            $peserta->noka,
            $peserta->nama,
            $peserta->no_hp,
            $peserta->alamat,
            $verifikasi ? ($verifikasi->terdaftar_rehab ? 'Ya' : 'Tidak') : 'Belum Cek',
            $verifikasi ? $verifikasi->tagihan_bulan_berjalan : 0,
            $sisa,
            $komunikasi ? \Carbon\Carbon::parse($komunikasi->tanggal_dihubungi)->format('Y-m-d H:i') : '-',
            $komunikasi ? str_replace('_', ' ', \Illuminate\Support\Str::title($komunikasi->status)) : '-',
            $komunikasi ? $komunikasi->catatan : '-',
        ];
    }
}
