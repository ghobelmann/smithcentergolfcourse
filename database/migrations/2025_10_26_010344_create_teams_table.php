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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('captain_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->decimal('entry_fee_paid', 8, 2)->default(0);
            $table->boolean('checked_in')->default(false);
            $table->datetime('registered_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
