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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_data')->nullable();
            $table->string('nama_file')->nullable();
            $table->integer('jumlah_data')->default(0);
            $table->boolean('is_baseline')->default(false);
            $table->string('status_import')->default('pending'); // pending, success, failed
            $table->foreignId('created_by')->constrained('users');
            $table->integer('total_valid')->default(0);
            $table->integer('total_invalid')->default(0);
            $table->integer('total_duplicate')->default(0);
            $table->integer('total_peserta_baru')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
