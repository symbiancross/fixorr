<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBiayaOnKeahlians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keahlians', function (Blueprint $table) {
            $table->string('biaya')->default('100000')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keahlians', function (Blueprint $table) {
            $table->string('biaya')->default('100000')->change();
        });
    }
}
