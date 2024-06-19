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
            $table->string('id_tour');
            $table->unsignedBigInteger('id_hotel');
            $table->timestamps();
            $table->foreign('id_hotel')->references('id')->on('hotel');
            $table->foreign('id_tour')->references('id')->on('tour');
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
