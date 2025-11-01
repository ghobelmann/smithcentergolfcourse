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
            $table->integer('number_of_flights')->default(1)->after('max_participants');
            $table->enum('tie_breaking_method', ['usga', 'hc_holes'])->default('usga')->after('number_of_flights');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn(['number_of_flights', 'tie_breaking_method']);
        });
    }
};
