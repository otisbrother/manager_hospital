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
        Schema::table('patients', function (Blueprint $table) {
            // Bỏ ràng buộc khóa ngoại insurance_id
            $table->dropForeign(['insurance_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Khôi phục lại ràng buộc khóa ngoại nếu cần rollback
            $table->foreign('insurance_id')
                ->references('id')
                ->on('health_insurance')
                ->nullOnDelete();
        });
    }
}; 