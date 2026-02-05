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
        Schema::table('location_meta_boards', function (Blueprint $table) {
            // Pricing Board Verknuepfung hinzufuegen
            $table->foreignId('pricing_id')->nullable()->after('barrierefreiheit')
                ->constrained('location_pricings')->nullOnDelete();

            // Preisfelder entfernen
            $table->dropColumn(['mietpreis_aufbautag', 'mietpreis_abbautag', 'mietpreis_va_tag']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location_meta_boards', function (Blueprint $table) {
            // Preisfelder wiederherstellen
            $table->decimal('mietpreis_aufbautag', 10, 2)->nullable()->after('flaeche_m2');
            $table->decimal('mietpreis_abbautag', 10, 2)->nullable()->after('mietpreis_aufbautag');
            $table->decimal('mietpreis_va_tag', 10, 2)->nullable()->after('mietpreis_abbautag');

            // Pricing Board Verknuepfung entfernen
            $table->dropConstrainedForeignId('pricing_id');
        });
    }
};
