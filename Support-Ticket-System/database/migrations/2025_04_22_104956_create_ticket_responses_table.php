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
        Schema::create('ticket_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('response_body');
            $table->unsignedBigInteger('parent_response_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_response_id')->references('id')->on('ticket_responses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_responses');
    }
};
