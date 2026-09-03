<?php

namespace App\Actions;

use App\Models\Batch;
use App\Models\Peserta;
use App\Models\PesertaBatch;
use Illuminate\Support\Facades\DB;
use App\Imports\PesertaImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Exception;

class ImportBatchAction
{
    public function execute($filePath, $originalName, $userId)
    {
        $collections = Excel::toCollection(new PesertaImport, $filePath);
        if ($collections->isEmpty() || $collections[0]->isEmpty()) {
            throw new Exception("File Excel kosong.");
        }

        $rows = $collections[0];
        
        // validate headers (at least noentitas exists)
        if (!isset($rows[0]['noentitas'])) {
            throw new Exception("Format Excel tidak valid. Kolom Noentitas tidak ditemukan. Harap gunakan format laporan dari SIPP.");
        }

        return DB::transaction(function () use ($rows, $originalName, $userId) {
            $isBaseline = Batch::count() === 0;

            $batch = Batch::create([
                'tanggal_data' => now(),
                'nama_file' => $originalName,
                'jumlah_data' => count($rows),
                'is_baseline' => $isBaseline,
                'status_import' => 'success',
                'created_by' => $userId,
            ]);

            $totalNew = 0;
            $totalValid = 0;

            foreach ($rows as $row) {
                if (empty($row['noentitas'])) continue;

                $totalValid++;

                // find or new
                $peserta = Peserta::where('noka', $row['noentitas'])->first();
                if (!$peserta) {
                    $peserta = new Peserta();
                    $peserta->noka = $row['noentitas'];
                    $totalNew++;
                }

                $peserta->nama = $row['namaentitas'] ?? $peserta->nama;
                $peserta->no_hp = $row['nohp'] ?? $peserta->no_hp;
                $peserta->email = $row['email'] ?? $peserta->email;
                $peserta->alamat = $row['alamat'] ?? $peserta->alamat;
                $peserta->status_aktif = $row['statusaktif'] ?? $peserta->status_aktif;
                $peserta->nopendaftar = $row['nopendaftar'] ?? $peserta->nopendaftar;
                $peserta->nopenghubung = $row['nopenghubung'] ?? $peserta->nopenghubung;
                
                if (!empty($row['startcicilan'])) {
                    $peserta->startcicilan = $this->parseDate($row['startcicilan']);
                }
                if (!empty($row['endcicilan'])) {
                    $peserta->endcicilan = $this->parseDate($row['endcicilan']);
                }
                
                $peserta->tglcicilan = $row['tglcicilan'] ?? $peserta->tglcicilan;
                
                $peserta->save();

                PesertaBatch::create([
                    'batch_id' => $batch->id,
                    'peserta_id' => $peserta->id,
                    'status_proses' => 'belum_diverifikasi',
                    'snapshot' => $row->toArray()
                ]);
            }

            $batch->update([
                'total_valid' => $totalValid,
                'total_peserta_baru' => $totalNew,
            ]);

            return $batch;
        });
    }

    private function parseDate($dateStr) {
        try {
            if (is_numeric($dateStr)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateStr)->format('Y-m-d');
            }
            return Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
