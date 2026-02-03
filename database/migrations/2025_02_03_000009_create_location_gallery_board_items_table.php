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
        Schema::create('location_gallery_board_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('gallery_board_id')->constrained('location_gallery_boards')->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);

            // Polymorphic media attachment (für Spatie Media Library oder ähnliches)
            $table->string('media_type')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();

            // User/Team-Kontext
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();

            $table->timestamps();

            // Indexe
            $table->index(['gallery_board_id', 'order']);
            $table->index(['media_type', 'media_id']);
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_gallery_board_items');
    }
};
