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
        Schema::create('tour_hotel', function (Blueprint $table) {
            $table->id();
            $table->string('matour');
            $table->unsignedBigInteger('maks');
            $table->timestamps();
            $table->foreign('maks')->references('id')->on('hotel')->constrained()->onDelete('restrict');
            $table->foreign('matour')->references('id')->on('tour')->constrained()->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_hotel');
    }
};
