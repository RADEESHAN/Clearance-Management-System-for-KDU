<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRankToApplicationStatusTable extends Migration
{
    public function up()
    {
        Schema::table('application_status', function (Blueprint $table) {
            // Add the rank column after the updated_by column
            $table->string('rank')->nullable()->after('updated_by');
        });
    }

    public function down()
    {
        Schema::table('application_status', function (Blueprint $table) {
            // Drop the rank column
            $table->dropColumn('rank');
        });
    }
}
