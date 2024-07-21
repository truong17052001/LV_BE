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
            $table->id();
            $table->string('sobooking');
            $table->date('ngay');
            $table->string('trangthai');
            $table->string('ten');
            $table->string('sdt');
            $table->text('email');
            $table->text('diachi');
            $table->integer('tongtien');
            $table->unsignedBigInteger('mand');
            $table->unsignedBigInteger('makh');
            $table->unsignedBigInteger('magg')->nullable();
            $table->timestamps();
            $table->foreign('mand')->references('id')->on('date_go');
            $table->foreign('makh')->references('id')->on('customer');
            $table->foreign('magg')->references('id')->on('discount');
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
