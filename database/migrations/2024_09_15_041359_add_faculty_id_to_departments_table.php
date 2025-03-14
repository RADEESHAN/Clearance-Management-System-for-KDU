<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacultyIdToDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            // Add the faculty_id column and set up the foreign key constraint
            $table->unsignedBigInteger('faculty_id')->nullable()->after('parent_department');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['faculty_id']);
            $table->dropColumn('faculty_id');
        });
    }
}
