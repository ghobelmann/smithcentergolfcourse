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
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Men's League 2025", "Women's League 2025"
            $table->text('description')->nullable();
            $table->enum('type', ['mens', 'womens', 'mixed'])->default('mixed');
            $table->date('season_start');
            $table->date('season_end');
            $table->string('day_of_week')->nullable(); // e.g., "Tuesday", "Wednesday"
            $table->time('tee_time')->nullable(); // e.g., "17:30:00", "09:00:00"
            $table->integer('holes')->default(9); // 9 or 18
            $table->decimal('entry_fee_per_week', 8, 2)->default(0);
            $table->decimal('season_fee', 8, 2)->default(0);
            $table->integer('max_members')->nullable();
            $table->integer('weeks_count_for_championship')->nullable(); // Best X weeks count
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft');
            
            // Scoring settings
            $table->string('points_system')->default('placement'); // placement, stroke_based, custom
            $table->json('points_structure')->nullable(); // Custom points per place
            $table->boolean('participation_points')->default(true);
            $table->integer('participation_points_value')->default(1);
            
            // Flight settings
            $table->integer('number_of_flights')->default(2);
            $table->boolean('flight_prizes')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};
