<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonNameToApplicationStatusTable extends Migration
{
    public function up()
    {
        Schema::table('application_status', function (Blueprint $table) {
            // Add the person_name column after the rank column
            $table->string('person_name')->nullable()->after('rank');
        });
    }

    public function down()
    {
        Schema::table('application_status', function (Blueprint $table) {
            // Drop the person_name column if the migration is rolled back
            $table->dropColumn('person_name');
        });
    }
}
