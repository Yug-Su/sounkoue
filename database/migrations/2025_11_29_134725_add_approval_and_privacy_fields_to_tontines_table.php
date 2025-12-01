<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tontines', function (Blueprint $table) {
            $table->boolean('require_approval')->default(false)->after('rotation_order');
            $table->boolean('is_private')->default(false)->after('require_approval');
        });
    }

    public function down(): void
    {
        Schema::table('tontines', function (Blueprint $table) {
            $table->dropColumn(['require_approval', 'is_private']);
        });
    }
};