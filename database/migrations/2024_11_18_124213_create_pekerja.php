<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePekerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_divisi');
            $table->string('nama_pekerja', 255);
            $table->string('nama_bank', 10);
            $table->string('rekening_pekerja', 50);
            $table->timestamps();
            $table->foreign('id_divisi')->references('id')->on('divisi')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerja');
    }
}
