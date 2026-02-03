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
        Schema::create('location_locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Verknüpfung zum Standort
            $table->foreignId('standort_id')->constrained('location_standorte')->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);

            // Adresse
            $table->string('street')->nullable();
            $table->string('street_number')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code', 2)->nullable(); // ISO 3166-1 alpha-2

            // GPS-Koordinaten
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // International
            $table->boolean('is_international')->default(false);
            $table->string('timezone')->nullable();

            // Kontakt
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('notes')->nullable();

            // User/Team-Kontext
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();

            // Status
            $table->boolean('done')->default(false);
            $table->timestamp('done_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexe
            $table->index(['standort_id']);
            $table->index(['team_id']);
            $table->index('uuid');
            $table->index('name');
            $table->index('country_code');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_locations');
    }
};
