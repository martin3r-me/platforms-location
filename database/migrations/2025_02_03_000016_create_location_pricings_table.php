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
        Schema::create('location_pricings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Verknuepfung zur Location
            $table->foreignId('location_id')->constrained('location_locations')->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);

            // Preisfelder
            $table->decimal('mietpreis_aufbautag', 10, 2)->nullable();
            $table->decimal('mietpreis_abbautag', 10, 2)->nullable();
            $table->decimal('mietpreis_va_tag', 10, 2)->nullable();

            // Gueltigkeitszeitraum
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('done')->default(false);
            $table->timestamp('done_at')->nullable();

            // User/Team-Kontext
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('location_pricings');
    }
};
