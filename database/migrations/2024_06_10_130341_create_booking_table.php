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
        Schema::create('booking', function (Blueprint $table) {
            $table->string('id_booking')->primary();
            $table->date('time_booking');
            $table->string('status');
            $table->string('name');
            $table->string('phone');
            $table->text('email');
            $table->text('address');
            $table->integer('total_price');
            $table->unsignedBigInteger('id_date');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_discount');
            $table->timestamps();
            $table->foreign('id_date')->references('id')->on('date_go');
            $table->foreign('id_customer')->references('id')->on('customer');
            $table->foreign('id_discount')->references('id')->on('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
