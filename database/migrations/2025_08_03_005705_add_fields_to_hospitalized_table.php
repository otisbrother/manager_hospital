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
        Schema::table('discharge', function (Blueprint $table) {
            $table->text('discharge_reason')->nullable()->after('discharge_date');
            $table->text('treatment_result')->nullable()->after('discharge_reason');
            $table->text('follow_up_instructions')->nullable()->after('treatment_result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discharge', function (Blueprint $table) {
            $table->dropColumn(['discharge_reason', 'treatment_result', 'follow_up_instructions']);
        });
    }
}; 