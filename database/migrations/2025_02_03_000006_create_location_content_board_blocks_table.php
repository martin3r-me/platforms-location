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
        Schema::create('location_content_board_blocks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('row_id')->constrained('location_content_board_rows')->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->integer('span')->default(12); // Grid span 1-12

            // Polymorphic content
            $table->string('content_type')->nullable();
            $table->unsignedBigInteger('content_id')->nullable();

            // User/Team-Kontext
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();

            $table->timestamps();

            // Indexe
            $table->index(['row_id', 'order']);
            $table->index(['content_type', 'content_id']);
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_content_board_blocks');
    }
};
