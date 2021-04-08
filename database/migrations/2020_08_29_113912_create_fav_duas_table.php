<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavDuasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fav_duas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('users_id')->unsigned()->index();
            $table->bigInteger('duas_id')->unsigned()->index();

            // foreign keys

            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('duas_id')->references('id')->on('duas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fav_duas', function ($table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['duas_id']);
            $table->dropColumn(['users_id', 'duas_id']);
        });
        Schema::dropIfExists('fav_duas');
    }
}
