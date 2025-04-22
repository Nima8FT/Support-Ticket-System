<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ticket_responses', function (Blueprint $table) {
            $table->enum('status', ['in_progress', 'answered', 'closed'])->default('in_progress')->after('parent_response_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_responses', function (Blueprint $table) {
            //
        });
    }
};
