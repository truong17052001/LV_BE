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
            $table->date('date');
            $table->integer('month');
            $table->integer('seat');
            $table->string('id_tour');
            $table->unsignedBigInteger('id_guider');
            $table->timestamps();
            $table->foreign('id_guider')->references('id')->on('tour_guider');
            $table->foreign('id_tour')->references('id')->on('tour');
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
