<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('student_info', function (Blueprint $table) {
        $table->string('bank')->nullable(); // Add 'bank' column
        $table->string('account_number')->nullable(); // Add 'account_number' column
    });
}

public function down()
{
    Schema::table('student_info', function (Blueprint $table) {
        $table->dropColumn(['bank', 'account_number']);
    });
}
};
