<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->string('user_name')->after('id'); // Add after 'id' (adjust as needed)
            $table->string('service_number')->after('user_name');
        });
    }

    public function down(): void
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->dropColumn(['user_name', 'service_number']);
        });
    }
};