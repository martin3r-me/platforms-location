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
        Schema::create('location_standorte', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            // Standort-spezifische Felder
            $table->string('name');
            $table->text('description')->nullable();
            
            // Verknüpfung zu Location
            $table->foreignId('location_id')->nullable()->constrained('location_locations')->nullOnDelete();
            
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
            $table->string('timezone')->nullable(); // z.B. 'Europe/Berlin', 'America/New_York'
            
            // Zusätzliche Felder
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('notes')->nullable();
            
            // User/Team-Kontext
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('owned_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexe für Performance
            $table->index(['team_id', 'is_active']);
            $table->index(['location_id', 'is_active']);
            $table->index(['created_by_user_id', 'owned_by_user_id']);
            $table->index('uuid');
            $table->index('name');
            $table->index('country_code');
            $table->index('is_international');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_standorte');
    }
};
