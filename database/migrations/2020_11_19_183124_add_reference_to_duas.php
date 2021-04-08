<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceToDuas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('duas', function (Blueprint $table) {
            $table->text('reference')->nullable()->after('transliteration');
            $table->text('urdu_translation')->nullable()->after('translation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('duas', function (Blueprint $table) {
            //
        });
    }
}
