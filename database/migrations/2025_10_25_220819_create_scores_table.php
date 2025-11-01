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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_entry_id')->constrained()->onDelete('cascade');
            $table->integer('hole_number');
            $table->integer('strokes');
            $table->integer('par')->default(4);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['tournament_entry_id', 'hole_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
