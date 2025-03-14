<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{

    public function up()
    {
        Schema::table('application_status', function (Blueprint $table) {
            // Add a new JSON column
            $table->json('receipt_paths')->nullable()->after('receipt_path');
        });
    
        // Migrate existing data from receipt_path to receipt_paths
        DB::statement('UPDATE application_status SET receipt_paths = JSON_ARRAY(receipt_path) WHERE receipt_path IS NOT NULL');
    
        // Remove the old column
        Schema::table('application_status', function (Blueprint $table) {
            $table->dropColumn('receipt_path');
        });
    }
    
    public function down()
    {
        Schema::table('application_status', function (Blueprint $table) {
            // Re-add the receipt_path column for rollback
            $table->string('receipt_path')->nullable()->after('receipt_paths');
        });
    
        // Rollback data migration
        DB::statement('UPDATE application_status SET receipt_path = JSON_UNQUOTE(JSON_EXTRACT(receipt_paths, "$[0]")) WHERE receipt_paths IS NOT NULL');
    
        // Drop the receipt_paths column
        Schema::table('application_status', function (Blueprint $table) {
            $table->dropColumn('receipt_paths');
        });
    }
};