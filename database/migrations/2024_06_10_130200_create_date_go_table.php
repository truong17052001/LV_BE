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
        Schema::create('date_go', function (Blueprint $table) {
            $table->id();
            $table->date('ngay');
            $table->integer('thang');
            $table->integer('songaydi');
            $table->integer('chongoi');
            $table->unsignedBigInteger('matour');
            $table->unsignedBigInteger('mahdv');
            $table->timestamps();
            $table->foreign('mahdv')->references('id')->on('tour_guider')->constrained()->onDelete('restrict');
            $table->foreign('matour')->references('id')->on('tour')->constrained()->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('date_go');
    }
};
