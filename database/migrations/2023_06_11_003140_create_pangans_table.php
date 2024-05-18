<?php

use App\Models\Komoditas;
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
        Schema::create('pangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('barang_id');
            $table->foreignId('komoditas_id');
            $table->string('satuan');
            $table->integer('qty');
            $table->integer('harga_sebelum')->nullable();
            $table->integer('harga');
            $table->string('pasar');
            $table->integer('perubahan_rp');
            $table->integer('perubahan_persen');
            $table->string('keterangan');
            $table->timestamp('periode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pangans');
    }
};
