<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('users_id')->unsigned()->index();
            $table->bigInteger('announcements_id')->unsigned()->index();

            // foreign keys
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('announcements_id')->references('id')->on('announcements')
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
        Schema::table('user_announcements', function ($table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['announcements_id']);
            $table->dropColumn(['users_id', 'announcements_id']);
        });
        Schema::dropIfExists('user_announcements');
    }
}
