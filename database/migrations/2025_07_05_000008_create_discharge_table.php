<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discharge', function (Blueprint $table) {
            $table->string('patient_id', 10); // MABN
            $table->date('discharge_date'); // NGXUATVIEN
            $table->timestamps();

            $table->primary(['patient_id', 'discharge_date']);
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discharge');
    }
};

