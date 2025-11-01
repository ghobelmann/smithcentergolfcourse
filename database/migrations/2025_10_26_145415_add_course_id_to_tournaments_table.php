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
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('course_tee_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['course_tee_id']);
            $table->dropColumn(['course_id', 'course_tee_id']);
        });
    }
};
