<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('reg_no')->unique();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('dep_id');
            $table->boolean('is_student')->default(false);
            $table->boolean('is_management')->default(false);
            $table->boolean('is_super_admin')->default(false);
            $table->timestamps();

            $table->foreign('dep_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}