<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('name'); // untuk fullName
            $table->text('address');
            $table->string('phone', 15);
            $table->string('ktp'); // path file foto ktp
            $table->string('kk');  // path file foto kk
            $table->string('email')->unique()->nullable(); // kalau mau nambahin email
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
