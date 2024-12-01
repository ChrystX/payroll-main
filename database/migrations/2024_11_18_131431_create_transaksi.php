<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('id_jadwal'); // Foreign key to jadwal table
            $table->unsignedBigInteger('id_pekerja'); // Foreign key to pekerja table
            $table->unsignedBigInteger('id_payment_account'); // Foreign key to payment_account table
            $table->date('tgl_byr'); // Payment date
            $table->time('wkt_byr'); // Payment time
            $table->decimal('nominal', 15, 2); // Payment amount
            $table->string('status', 50)->default('pending'); // Payment status (e.g., pending, completed)
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('id_jadwal')->references('id')->on('jadwal')->onDelete('cascade');
            $table->foreign('id_pekerja')->references('id')->on('pekerja')->onDelete('cascade');
            $table->foreign('id_payment_account')->references('id')->on('sumber_dana')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
