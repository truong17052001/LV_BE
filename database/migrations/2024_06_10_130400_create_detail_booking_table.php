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
        Schema::create('detail_booking', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->string('gioitinh');
            $table->date('ngaysinh');
            $table->integer('loai');
            $table->unsignedBigInteger('mabooking');
            $table->timestamps();
            $table->foreign('mabooking')->references('id')->on('booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_booking');
    }
};
