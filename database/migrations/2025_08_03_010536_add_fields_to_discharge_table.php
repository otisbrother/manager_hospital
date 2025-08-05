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
            if (!Schema::hasColumn('discharge', 'discharge_reason')) {
                $table->text('discharge_reason')->nullable()->after('discharge_date');
            }

            if (!Schema::hasColumn('discharge', 'treatment_result')) {
                $table->text('treatment_result')->nullable()->after('discharge_reason');
            }

            if (!Schema::hasColumn('discharge', 'follow_up_instructions')) {
                $table->text('follow_up_instructions')->nullable()->after('treatment_result');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discharge', function (Blueprint $table) {
            if (Schema::hasColumn('discharge', 'discharge_reason')) {
                $table->dropColumn('discharge_reason');
            }

            if (Schema::hasColumn('discharge', 'treatment_result')) {
                $table->dropColumn('treatment_result');
            }

            if (Schema::hasColumn('discharge', 'follow_up_instructions')) {
                $table->dropColumn('follow_up_instructions');
            }
        });
    }
};
