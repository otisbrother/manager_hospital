<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // ID tự tăng cho mỗi lịch hẹn
            $table->string('patient_id');     // FK -> patients.id (string như "BN10229")
            $table->string('doctor_id');      // FK -> doctors.id (string như "BS011")
            $table->string('department_id');  // FK -> departments.id (string như "KH001")
            $table->dateTime('appointment_date');
            $table->text('symptoms')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
