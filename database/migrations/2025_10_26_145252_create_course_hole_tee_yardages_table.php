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
        Schema::create('course_hole_tee_yardages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_hole_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_tee_id')->constrained()->onDelete('cascade');
            $table->integer('yardage');
            $table->timestamps();
            
            $table->unique(['course_hole_id', 'course_tee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_hole_tee_yardages');
    }
};
