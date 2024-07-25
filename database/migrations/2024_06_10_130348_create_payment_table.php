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
            $table->integer('giatri');
            $table->string('trangthai');
            $table->string('pttt');
            $table->unsignedBigInteger('mabooking');
            $table->unsignedBigInteger('makh');
            $table->timestamps();
            $table->foreign('mabooking')->references('id')->on('booking');
            $table->foreign('makh')->references('id')->on('users');
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
