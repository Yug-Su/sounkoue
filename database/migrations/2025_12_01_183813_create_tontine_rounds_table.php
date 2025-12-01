<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tontine_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tontine_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiary_id')->constrained('users')->onDelete('cascade');
            $table->integer('round_number');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->decimal('expected_amount', 15, 2);
            $table->decimal('collected_amount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['tontine_id', 'round_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tontine_rounds');
    }
};