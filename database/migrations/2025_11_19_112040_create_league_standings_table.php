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
        Schema::create('league_standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tournament_id')->nullable()->constrained()->onDelete('cascade'); // Weekly tournament
            $table->integer('week_number')->nullable(); // Which week of the season
            
            // Weekly stats
            $table->integer('position')->nullable(); // 1st, 2nd, 3rd, etc.
            $table->integer('flight')->nullable(); // Which flight they were in
            $table->integer('position_in_flight')->nullable(); // Position within their flight
            $table->integer('total_score')->nullable();
            $table->integer('score_vs_par')->nullable();
            $table->integer('points_earned')->default(0); // Points for this week
            $table->boolean('participated')->default(false);
            
            // Season cumulative (updated after each week)
            $table->integer('total_points')->default(0);
            $table->integer('weeks_played')->default(0);
            $table->integer('best_score')->nullable();
            $table->integer('worst_score')->nullable();
            $table->decimal('average_score', 8, 2)->nullable();
            
            $table->timestamps();
            
            // Index for efficient queries
            $table->index(['league_id', 'user_id']);
            $table->index(['league_id', 'week_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_standings');
    }
};
