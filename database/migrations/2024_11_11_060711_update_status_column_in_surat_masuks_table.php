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
        Schema::table('surat_masuks', function (Blueprint $table) {
            // Menghapus kolom status lama bertipe varchar
            $table->dropColumn('status');

            // Menambahkan kolom status baru dengan tipe integer
            // $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            // Menghapus kolom status baru jika rollback
            $table->dropColumn('status');

            // Menambahkan kolom status lama bertipe varchar jika rollback
            // $table->string('status')->nullable();
        });
    }
};
