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
        Schema::table('tournament_entries', function (Blueprint $table) {
            $table->integer('starting_hole')->nullable()->after('checked_in');
            $table->enum('group_letter', ['A', 'B'])->nullable()->after('starting_hole');
            $table->integer('card_order')->nullable()->after('group_letter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_entries', function (Blueprint $table) {
            $table->dropColumn(['starting_hole', 'group_letter', 'card_order']);
        });
    }
};
