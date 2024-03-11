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
        Schema::create('pembayaran_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pemesanan_pembelian_id');
            $table->string('nominal');
            $table->foreign('pemesanan_pembelian_id')->references('id')->on('pesanan_pembelian')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('status');
            $table->softDeletes()->nullable();
            $table->integer('created_by');
            $table->integer('deleted_by')->nullable();
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pembelian');
    }
};
