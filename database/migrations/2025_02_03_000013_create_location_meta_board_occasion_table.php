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
        Schema::create('location_meta_board_occasion', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meta_board_id')->constrained('location_meta_boards')->cascadeOnDelete();
            $table->foreignId('occasion_id')->constrained('location_occasions')->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['meta_board_id', 'occasion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_meta_board_occasion');
    }
};
