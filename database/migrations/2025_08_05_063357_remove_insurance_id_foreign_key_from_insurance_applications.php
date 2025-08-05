<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insurance_applications', function (Blueprint $table) {
            // Xóa foreign key constraint cho insurance_id
            $table->dropForeign(['insurance_id']);
        });
    }

    public function down(): void
    {
        Schema::table('insurance_applications', function (Blueprint $table) {
            // Thêm lại foreign key constraint nếu cần rollback
            $table->foreign('insurance_id')->references('id')->on('health_insurance');
        });
    }
}; 