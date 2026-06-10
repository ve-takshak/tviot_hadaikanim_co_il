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
        Schema::table('lawsuits', function (Blueprint $table) {
            $table->tinyInteger('status')
            ->default(1)
            ->comment('1: Active, 0: Inactive, 2: Repeated claims for settlement/policy, 3: Under attorney management/handling 4: Settlement / policy claims')
            ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lawsuits', function (Blueprint $table) {
            $table->tinyInteger('status')
                  ->default(1)
                  ->change();
        });
    }
};
