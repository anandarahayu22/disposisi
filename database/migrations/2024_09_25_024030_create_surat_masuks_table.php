<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('pengirim');
            $table->string('tujuan');
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('status')->default('pending');
            $table->text('deskripsi')->nullable();
            $table->string('file_surat')->nullable(); // Kolom untuk menyimpan file surat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_masuks'); // Ganti 's' dengan nama tabel yang benar
    }
};
