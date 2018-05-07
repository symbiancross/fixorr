<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationTokenTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_token_tukangs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tukang_id')->unsigned()->index();
            $table->string('token');
            $table->timestamps();
            $table->foreign('tukang_id')->references('tukang_id')->on('tukangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_token_tukangs');
    }
}
