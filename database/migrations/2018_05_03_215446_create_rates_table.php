<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('rate_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->integer('tukang_id')->unsigned();
            $table->foreign('tukang_id')->references('tukang_id')->on('tukangs')->onDelete('cascade');
            $table->integer('pesan_id')->unsigned();
            $table->foreign('pesan_id')->references('pesan_id')->on('pesans')->onDelete('cascade');
            $table->string('foto_testimoni')->nullable();
            $table->tinyInteger('rate_tukang')->default(0);
            $table->tinyInteger('rate_pengguna')->default(0);
            $table->string('testimoni')->nullable();
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
        Schema::dropIfExists('rates');
    }
}
