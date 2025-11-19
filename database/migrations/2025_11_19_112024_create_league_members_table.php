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
        Schema::create('league_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('handicap', 5, 2)->nullable();
            $table->decimal('season_fee_paid', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->date('joined_date');
            $table->date('last_played')->nullable();
            $table->integer('weeks_played')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Ensure unique membership per league
            $table->unique(['league_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_members');
    }
};
