<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relative', function (Blueprint $table) {
            $table->string('patient_id', 10); // MABN
            $table->string('name', 30); // TENTN
            $table->string('gender', 3)->nullable(); // PHAI
            $table->date('dob')->nullable(); // NGAYSINH
            $table->string('relationship', 15)->nullable(); // QUANHE
            $table->timestamps();

            $table->primary(['patient_id', 'name']); // Khóa chính kép
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relative');
    }
};