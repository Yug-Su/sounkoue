<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tontine_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type'); // contribution, distribution, deposit, withdrawal
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('XOF');
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('payment_method')->nullable(); // wallet, mobile_money
            $table->string('external_reference')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};