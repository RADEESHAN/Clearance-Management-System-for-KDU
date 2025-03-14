<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('id');
            $table->string('dep_name');
            $table->string('email')->nullable(); // Add email field here
            $table->unsignedBigInteger('parent_department')->nullable();
            $table->timestamps();

            $table->foreign('parent_department')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
