<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tontines', function (Blueprint $table) {
            $table->json('turn_order')->nullable()->after('current_round');
            $table->timestamp('next_turn_date')->nullable()->after('turn_order');
            $table->timestamp('last_contribution_date')->nullable()->after('next_turn_date');
            $table->boolean('auto_advance_turns')->default(true)->after('last_contribution_date');
        });
    }

    public function down(): void
    {
        Schema::table('tontines', function (Blueprint $table) {
            $table->dropColumn(['turn_order', 'next_turn_date', 'last_contribution_date', 'auto_advance_turns']);
        });
    }
};