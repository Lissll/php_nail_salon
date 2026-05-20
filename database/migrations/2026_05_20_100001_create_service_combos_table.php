<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_combos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('service_id_1')->constrained('services')->cascadeOnDelete();
            $table->foreignId('service_id_2')->constrained('services')->cascadeOnDelete();
            $table->unsignedTinyInteger('discount_percent')->default(15);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_combos');
    }
};
