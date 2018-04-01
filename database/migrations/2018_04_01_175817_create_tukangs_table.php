<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tukangs', function (Blueprint $table) {
            $table->increments('tukang_id');
            $table->string('nama');
            $table->string('alamat');
            $table->string('email')->unique();
            $table->string('no_telp');
            $table->string('password');
            $table->string('foto');
            $table->integer('keahlian_id')->unsigned();
            $table->foreign('keahlian_id')->references('keahlian_id')->on('keahlians')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('tukangs');
    }
}
