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
        Schema::create('permintaan_jasa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('perusahaan_id');
            $table->date('tanggal_approve')->nullable();
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('nominal');
            $table->integer('tipe');
            $table->foreign('client_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('perusahaan_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('permintaan_jasa');
    }
};
