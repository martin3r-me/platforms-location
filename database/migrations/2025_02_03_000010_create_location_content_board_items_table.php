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
        Schema::create('location_content_board_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('content_board_id')->constrained('location_content_boards')->cascadeOnDelete();

            $table->text('content')->nullable();
            $table->integer('order')->default(0);

            // User/Team-Kontext
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();

            $table->timestamps();

            // Indexe
            $table->index(['content_board_id', 'order']);
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_content_board_items');
    }
};
