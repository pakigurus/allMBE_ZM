<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributeWithSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribute_with_skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('skills')->nullable();
            $table->bigInteger('skills_id')->unsigned()->index()->nullable();
            $table->foreign('skills_id')
                ->references('id')
                ->on('skills')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('masajids_id')->unsigned()->index()->nullable();
            $table->foreign('masajids_id')->references('id')->on('masajids')
                ->onDelete('cascade');
            $table->bigInteger('users_id')->unsigned()->index()->nullable();
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->string('time_flag')->nullable();
            $table->longText('description')->nullable();
            $table->longText('bio')->nullable();
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
        Schema::table('contribute_with_skills', function ($table) {
            $table->dropForeign(['skills_id']);
            $table->dropForeign(['masajids_id']);
            $table->dropForeign(['users_id']);
            $table->dropColumn(['users_id', 'skills_id','masajids_id']);
        });
        Schema::dropIfExists('contribute_with_skills');
    }
}
