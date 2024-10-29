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
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->string('surat_id');
            $table->string('pengirim_id');
            $table->string('penerima_id');
            $table->text('disposisi');
            $table->text('Keterangan')->nullable();
            $table->string('status');
            $table->dateTime('tgl_verifikasi');
            $table->string('Read')->default(0);
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
        Schema::dropIfExists('disposisis');
    }
};
