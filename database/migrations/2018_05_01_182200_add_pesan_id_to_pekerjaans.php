<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPesanIdToPekerjaans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->integer('pesan_id')->unsigned();
            $table->foreign('pesan_id')->references('pesan_id')->on('pesans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pekerjaans', function (Blueprint $table) {
            $table->integer('pesan_id')->unsigned();
            $table->foreign('pesan_id')->references('pesan_id')->on('pesans')->onDelete('cascade');
        });
    }
}
