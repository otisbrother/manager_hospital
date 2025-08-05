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
        Schema::table('health_insurance', function (Blueprint $table) {
            $table->decimal('coverage_percentage', 5, 2)->default(80.00)->after('expire_date');
            $table->string('type', 50)->nullable()->after('coverage_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('health_insurance', function (Blueprint $table) {
            $table->dropColumn(['coverage_percentage', 'type']);
        });
    }
}; 