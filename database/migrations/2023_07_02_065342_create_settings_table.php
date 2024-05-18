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
        
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->default('Nama App');
            $table->string('text')->default('text');  
            $table->string('copyright')->default('ini copyright');
            $table->string('alamat')->default('alamattt');
            $table->string('email')->default('emaill');
            $table->string('telepon')->default('teleponnnn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
