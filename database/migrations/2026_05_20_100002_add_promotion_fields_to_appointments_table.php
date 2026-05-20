<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('service_combo_id')->nullable()->after('service_id')->constrained('service_combos')->nullOnDelete();
            $table->unsignedTinyInteger('discount_percent')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_combo_id');
            $table->dropColumn('discount_percent');
        });
    }
};
