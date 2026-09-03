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
        Schema::create('komunikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('pesertas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->string('no_hp')->nullable();
            $table->string('template')->nullable();
            $table->text('pesan')->nullable();
            $table->string('status')->nullable(); // sudah_dihubungi, tidak_terdaftar_wa, gagal
            $table->date('tanggal_dihubungi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komunikasis');
    }
};
