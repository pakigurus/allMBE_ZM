<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('masajids_id')->unsigned()->index();

            // foreign keys
            $table->foreign('masajids_id')->references('id')->on('masajids')
                ->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->boolean('status')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function ($table) {
            $table->dropForeign(['masajids_id']);
            $table->dropColumn('masajids_id');
        });
        Schema::dropIfExists('announcements');
    }
}
