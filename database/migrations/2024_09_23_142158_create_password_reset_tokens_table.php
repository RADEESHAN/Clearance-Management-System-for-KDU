<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetTokensTable extends Migration
{
    public function up()
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->index(); // Email of the user
            $table->string('token');          // Token for resetting password
            $table->timestamp('created_at')->nullable(); // Timestamp when the token was created
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_reset_tokens');
    }
}
