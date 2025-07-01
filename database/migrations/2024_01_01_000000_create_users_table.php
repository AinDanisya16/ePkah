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
            $table->string('id')->primary();
            $table->string('peranan');
            $table->string('nama');
            $table->string('id_kakitangan')->nullable();
            $table->string('email')->unique();
            $table->string('telefon')->unique();
            $table->text('alamat');
            $table->string('poskod');
            $table->string('jajahan');
            $table->string('negeri');
            $table->string('password');
            $table->string('nama_syarikat')->nullable();
            $table->string('no_syarikat')->nullable();
            $table->json('lokasi_kutipan')->nullable();
            $table->json('jenis_barang')->nullable();
            $table->string('status')->default('approved');
            $table->timestamp('email_verified_at')->nullable();
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