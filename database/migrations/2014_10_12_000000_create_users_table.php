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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('matkhau');
            $table->rememberToken();
            $table->string('sdt')->nullable();
            $table->text('diachi')->nullable();
            $table->text('anh')->nullable();
            $table->string('gioitinh')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('quyen');
            $table->integer('dakichhoat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
