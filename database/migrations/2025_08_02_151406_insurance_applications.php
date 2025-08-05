<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurance_applications', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id', 10);
            $table->string('insurance_id', 15)->nullable(); // Mã BHYT
            $table->enum('support_level', ['80', '95', '100'])->default('80'); // Mức hỗ trợ: 80%, 95%, 100%
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Trạng thái duyệt
            $table->text('proof_images')->nullable(); // JSON chứa đường dẫn ảnh chứng minh
            $table->text('admin_notes')->nullable(); // Ghi chú của admin
            $table->string('approved_by')->nullable(); // Admin duyệt
            $table->timestamp('approved_at')->nullable(); // Thời gian duyệt
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('insurance_id')->references('id')->on('health_insurance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_applications');
    }
}; 