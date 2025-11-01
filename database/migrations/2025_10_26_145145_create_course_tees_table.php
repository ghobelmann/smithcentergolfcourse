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
        Schema::create('course_tees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Championship", "Blue", "White", "Red"
            $table->string('color')->nullable(); // Color designation
            $table->decimal('rating', 4, 1); // Course rating (e.g., 72.1)
            $table->integer('slope'); // Slope rating (55-155)
            $table->integer('total_yardage')->nullable(); // Total yardage from this tee
            $table->string('gender')->default('mixed'); // men, women, mixed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_tees');
    }
};
