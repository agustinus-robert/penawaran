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
        Schema::create('penawaran_jasa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pekerjaan_id');
            $table->unsignedBigInteger('perusahaan_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('proyek_id');
            $table->unsignedBigInteger('tipe_pekerjaan_id');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('nominal');
            $table->integer('approve');
            $table->date('approved_at')->nullable();
            $table->integer('tipe');
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('perusahaan_id')->references('id')->on('ref_perusahaan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('client')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('proyek_id')->references('id')->on('proyek')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tipe_pekerjaan_id')->references('id')->on('tipe_pekerjaan')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('penawaran_jasa');
    }
};
