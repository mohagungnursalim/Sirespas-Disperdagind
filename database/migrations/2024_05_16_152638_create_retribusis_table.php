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
        Schema::create('retribusis', function (Blueprint $table) {
            $table->id();
            $table->string('pasar');
            $table->string('nama_pedagang');
            $table->string('alamat');
            $table->string('jenis_retribusi');
            $table->decimal('jumlah_pembayaran');
            $table->string('metode_pembayaran');
            $table->int('no_pembayaran');
            $table->text('keterangan')->nullable();
            $table->string('petugas_penerima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retribusis');
    }
};
