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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignID('tagihan_id')->constrained('tagihan')->onDelete('cascade');
            $table->foreignID('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_bayar');
            $table->decimal('total_harga', 10, 2);
            $table->string('metode_pembayaran');
            $table->enum('status', ['belum bayar', 'sudah bayar'])->default('belum bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
