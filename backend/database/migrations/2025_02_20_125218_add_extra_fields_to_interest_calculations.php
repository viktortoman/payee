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
        Schema::table('interest_calculations', function (Blueprint $table) {
            $table->integer('days_count')->after('calculated_interest');
            $table->string('interest_rate')->after('days_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interest_calculations', function (Blueprint $table) {
            $table->dropColumn('days_count');
            $table->dropColumn('interest_rate');
        });
    }
};
