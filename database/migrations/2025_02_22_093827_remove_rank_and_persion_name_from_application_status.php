<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration {
    public function up(): void
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->dropColumn(['rank', 'person_name']);
        });
    }

    public function down(): void
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->string('rank')->nullable();
            $table->string('person_name')->nullable();
        });
    }
};