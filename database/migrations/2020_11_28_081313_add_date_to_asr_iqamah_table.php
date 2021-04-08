<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateToAsrIqamahTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asr_iqamah', function (Blueprint $table) {
            $table->date('date')->after('time')->nullable();
            $table->timestamp('timestamp')->after('date')->nullable();
        });
        Schema::table('isha_iqamah', function (Blueprint $table) {
            $table->date('date')->after('time')->nullable();
//            $table->timestamp('timestamp')->after('date')->nullable();
        });

//        if (Schema::hasColumn('asr_iqamah', 'to_date'))
//        {
//            Schema::table('asr_iqamah', function (Blueprint $table)
//            {
//                $table->dropColumn('to_date');
//            });
//        }
//        if (Schema::hasColumn('asr_iqamah', 'end_date'))
//        {
//            Schema::table('asr_iqamah', function (Blueprint $table)
//            {
//                $table->dropColumn('end_date');
//            });
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asr_iqamah', function (Blueprint $table) {
            //
        });
    }
}
