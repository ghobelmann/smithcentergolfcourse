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
        Schema::table('tournaments', function (Blueprint $table) {
            $table->foreignId('league_id')->nullable()->after('id')->constrained()->onDelete('set null');
            $table->integer('week_number')->nullable()->after('league_id'); // Week in league season
            $table->boolean('counts_for_championship')->default(true)->after('week_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropForeign(['league_id']);
            $table->dropColumn(['league_id', 'week_number', 'counts_for_championship']);
        });
    }
};
