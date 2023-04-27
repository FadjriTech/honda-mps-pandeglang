<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motocross', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('kelas', ['Utama Motocross', 'Grass Track', 'Executive']);
            $table->integer('biaya');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('motocross');
    }
};
