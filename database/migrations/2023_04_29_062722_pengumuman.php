<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->enum('jenis', ['peraturan', 'pemenang']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('pengumuman');
    }
};
