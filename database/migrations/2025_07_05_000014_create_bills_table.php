<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->string('id', 20)->primary(); // MAHD
            $table->string('health_insurance_id', 15)->nullable(); // MABHYT
            $table->string('patient_id', 10); // MABN
            $table->string('prescription_id', 20)->nullable(); // MADT
            $table->decimal('total', 15, 2)->nullable(); // TONGTIEN
            $table->timestamps();

            $table->foreign('health_insurance_id')->references('id')->on('health_insurance');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('prescription_id')->references('id')->on('prescriptions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};