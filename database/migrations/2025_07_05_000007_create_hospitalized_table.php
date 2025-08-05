<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitalized', function (Blueprint $table) {
            $table->string('patient_id', 10); // MABN
            $table->date('admission_date'); // NGNHAPVIEN
            $table->string('room', 10); // PHONG
            $table->integer('bed'); // GIUONG
            $table->timestamps();

            $table->primary(['patient_id', 'room', 'bed']);
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitalized');
    }
};