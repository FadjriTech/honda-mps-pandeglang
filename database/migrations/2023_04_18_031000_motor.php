<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motor', function (Blueprint $table) {
            $table->id();
            $table->string('merk');
            $table->string('mesin');
            $table->string('rangka');
            $table->string('kategori');
            $table->string('kelas');
            $table->integer('biaya');
            $table->unsignedBigInteger('participantId');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('motor');
    }
};
