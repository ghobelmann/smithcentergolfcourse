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
        Schema::table('scores', function (Blueprint $table) {
            // Only add team_id if it doesn't exist
            if (!Schema::hasColumn('scores', 'team_id')) {
                $table->foreignId('team_id')->nullable()->after('tournament_entry_id')->constrained()->onDelete('cascade');
            }
            
            // Make tournament_entry_id nullable since we'll use either tournament_entry_id OR team_id
            $table->foreignId('tournament_entry_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
            
            // Restore tournament_entry_id as not nullable
            $table->foreignId('tournament_entry_id')->nullable(false)->change();
            
            // Restore unique constraint
            $table->unique(['tournament_entry_id', 'hole_number']);
        });
    }
};
