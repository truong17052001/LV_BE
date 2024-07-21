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
        Schema::create('tour_vehicle', function (Blueprint $table) {
            $table->id();
            $table->string('matour');
            $table->unsignedBigInteger('mapt');
            $table->timestamps();
            $table->foreign('mapt')->references('id')->on('vehicle');
            $table->foreign('matour')->references('id')->on('tour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_vehicle');
    }
};
