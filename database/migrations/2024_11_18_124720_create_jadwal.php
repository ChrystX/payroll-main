<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('selected_date'); // Date for scheduled payments
            $table->string('status', 50)->default('pending'); // Status of the schedule (e.g., pending, completed)
            $table->unsignedBigInteger('id_payment_account');
            $table->timestamps(); // created_at and updated_at

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
        Schema::dropIfExists('jadwal');
    }
}
