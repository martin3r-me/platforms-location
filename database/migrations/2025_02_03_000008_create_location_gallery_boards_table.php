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
        Schema::create('location_gallery_boards', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Verknüpfung zur Location
            $table->foreignId('location_id')->constrained('location_locations')->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);

            // User/Team-Kontext
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();

            // Status
            $table->boolean('done')->default(false);
            $table->timestamp('done_at')->nullable();

            $table->timestamps();

            // Indexe
            $table->index(['location_id']);
            $table->index(['team_id']);
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_gallery_boards');
    }
};
