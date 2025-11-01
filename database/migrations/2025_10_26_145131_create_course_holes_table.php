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
        Schema::create('course_holes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('hole_number'); // 1-18
            $table->integer('par'); // 3, 4, or 5
            $table->integer('handicap'); // 1-18 handicap ranking
            $table->string('name')->nullable(); // Optional hole name
            $table->timestamps();
            
            $table->unique(['course_id', 'hole_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_holes');
    }
};
