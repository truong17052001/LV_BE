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
        Schema::create('tour_guider', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->string('sdt');
            $table->string('diachi');
            $table->text('email')->nullable();
            $table->text('anh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_guider');
    }
};
