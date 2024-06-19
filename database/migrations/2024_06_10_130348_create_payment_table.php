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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->integer('price_paid');
            $table->integer('price_unpaid');
            $table->string('method');
            $table->unsignedBigInteger('id_booking');
            $table->unsignedBigInteger('id_customer');
            $table->timestamps();
            $table->foreign('id_booking')->references('id_booking')->on('booking');
            $table->foreign('id_customer')->references('id')->on('customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
