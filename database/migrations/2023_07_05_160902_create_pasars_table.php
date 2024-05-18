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
        Schema::create('pasars', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('image');
            $table->string('tahun_pembangunan');
            $table->string('luas_lahan');
            $table->string('sertifikat');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('status_pasar');
            $table->string('pedagang');
            $table->string('kios_petak');
            $table->string('los_petak');
            $table->string('lapak_pelataran');
            $table->string('ruko');
            $table->string('baik');
            $table->string('rusak');
            $table->string('terpakai');
            $table->string('kepala_pasar');
            $table->string('kebersihan');
            $table->string('keamanan');
            $table->string('retribusi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasars');
    }
};
