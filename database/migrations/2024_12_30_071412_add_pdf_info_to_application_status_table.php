<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdfInfoToApplicationStatusTable extends Migration
{
    public function up()
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->after('reason');
            // Add any other necessary columns, e.g., pdf_reason
            $table->text('pdf_reason')->nullable()->after('pdf_path');
        });
    }

    public function down()
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->dropColumn(['pdf_path', 'pdf_reason']);
        });
    }
}