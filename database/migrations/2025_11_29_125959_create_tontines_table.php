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
        Schema::create('tontines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount_per_contribution', 15, 2);
            $table->enum('frequency', ['weekly', 'biweekly', 'monthly', 'quarterly']);
            $table->integer('max_members');
            $table->enum('rotation_order', ['random', 'alphabetical', 'custom']);
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('rotation_sequence')->nullable();
            $table->integer('current_round')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tontines');
    }
};
