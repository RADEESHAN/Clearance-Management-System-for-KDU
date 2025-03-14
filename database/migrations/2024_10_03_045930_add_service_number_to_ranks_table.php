<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceNumberToRanksTable extends Migration
{
    public function up()
    {
        Schema::table('ranks', function (Blueprint $table) {
            $table->string('service_number')->after('person_name'); // Add the new column
        });
    }

    public function down()
    {
        Schema::table('ranks', function (Blueprint $table) {
            $table->dropColumn('service_number'); // Rollback the column
        });
    }
}
