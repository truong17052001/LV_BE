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
        Schema::create('tour_place', function (Blueprint $table) {
            $table->id();
            $table->string('matour');
            $table->unsignedBigInteger('madd');
            $table->timestamps();
            $table->foreign('madd')->references('id')->on('place');
            $table->foreign('matour')->references('id')->on('tour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_place');
    }
};
