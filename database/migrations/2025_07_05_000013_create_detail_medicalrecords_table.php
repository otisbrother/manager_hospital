<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_medicalrecords', function (Blueprint $table) {
            $table->string('medical_record_id', 30); // MASKB
            $table->string('patient_id', 10); // MABN
            $table->date('exam_date'); // NGAYKHAM
            $table->string('prescription_id', 10)->nullable(); // MADT
            $table->string('disease_name', 40)->nullable(); // TENBENH
            $table->string('department_id', 10); // MAKHOA
            $table->timestamps();

            $table->primary(['medical_record_id', 'patient_id', 'exam_date']);
            $table->foreign('medical_record_id')->references('id')->on('medical_records');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('prescription_id')->references('id')->on('prescriptions');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_medicalrecord');
    }
};