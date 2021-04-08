<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('users_id')->unsigned()->index();
            $table->bigInteger('events_id')->unsigned()->index();

            // foreign keys
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('events_id')->references('id')->on('events')
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
        Schema::table('user_events', function ($table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['events_id']);
            $table->dropColumn(['users_id', 'events_id']);
        });
        Schema::dropIfExists('user_events');
    }
}
