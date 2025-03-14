<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentInfoTable extends Migration
{
    public function up()
    {
        Schema::create('student_info', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('student_reg_no')->unique();
            $table->unsignedBigInteger('faculty_id');
            $table->string('tel_no');
            $table->enum('student_type', ['DAYSCHOLAR', 'STUDENTOFFICER']); //CHANGED
            $table->string('kdu_id')->unique();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_info');
    }
}