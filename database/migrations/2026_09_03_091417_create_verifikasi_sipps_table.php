<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('verifikasi_sipps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('pesertas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal_cek');
            $table->boolean('terdaftar_rehab')->default(false);
            $table->date('tanggal_daftar_rehab')->nullable();
            $table->integer('jumlah_peserta_sipp')->default(1);
            $table->decimal('tagihan_bulan_berjalan', 15, 2)->default(0);
            $table->decimal('tagihan_sebelum_bulan_berjalan', 15, 2)->default(0);
            $table->string('status_pembayaran_bulan_berjalan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_sipps');
    }
};
