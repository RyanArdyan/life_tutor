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
        // skema buat table users, jalankan fungsi berikut, cetakbiru $meja
        Schema::create('users', function (Blueprint $table) {
            // buat tipe data big integer yang auto increment dan primary key atau kunci utama
            $table->bigIncrements('user_id');
            // defaultnya adalah 3, 3 berarti pelanggan, 1 berarti admin, 2 berarti tutor
            $table->tinyInteger('role_id')->default(3);
            // nullable berarti nilainya boleh kosong
            $table->string('foto')->nullable();
            // tipe varchar, column name, valuenya tidak boleh sama
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
