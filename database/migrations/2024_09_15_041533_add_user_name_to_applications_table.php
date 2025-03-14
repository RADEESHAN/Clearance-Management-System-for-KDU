<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserNameToApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            // Add the user_name column after the student_id column
            $table->string('user_name')->nullable()->after('student_id');
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            // Drop the user_name column
            $table->dropColumn('user_name');
        });
    }
}
