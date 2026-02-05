<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('location_pricings', function (Blueprint $table) {
            $table->decimal('energiekosten_pro_tag', 10, 2)->nullable()->after('mietpreis_va_tag');
            $table->text('preisanmerkungen')->nullable()->after('energiekosten_pro_tag');
        });
    }

    public function down(): void
    {
        Schema::table('location_pricings', function (Blueprint $table) {
            $table->dropColumn(['energiekosten_pro_tag', 'preisanmerkungen']);
        });
    }
};
