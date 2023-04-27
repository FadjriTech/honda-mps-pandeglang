<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon');
            $table->string('KIS');
            $table->date('tanggal_lahir');
            $table->integer('start');
            $table->string('tim');
            $table->string('kota');
            $table->enum('konfirmasi', ['Konfirmasi', 'Belum Di Konfirmasi'])->default('Belum Di Konfirmasi');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('participant');
    }
};
