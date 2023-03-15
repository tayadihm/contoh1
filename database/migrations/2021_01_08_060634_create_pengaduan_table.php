<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('user_nik');
            $table->integer('user_id');
            $table->string('name');
            $table->string('norek_nasabah');
            $table->string('id_nasabah');
            $table->string('phone_nasabah', 13);
            $table->string('jenis_pengaduan');
            $table->text('description');
            $table->string('berkas');
            $table->string('status')->default('Belum di Proses');
            $table->softDeletes();
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
        Schema::dropIfExists('pengaduan');
    }
}
