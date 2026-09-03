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
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('noka')->unique();
            $table->string('nama')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('status_aktif')->nullable();
            $table->string('nopendaftar')->nullable();
            $table->string('nopenghubung')->nullable();
            $table->date('startcicilan')->nullable();
            $table->date('endcicilan')->nullable();
            $table->integer('tglcicilan')->nullable();
            $table->date('tanggal_update_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
