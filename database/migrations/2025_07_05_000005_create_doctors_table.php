<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->string('id', 10)->primary(); // MABS
            $table->string('name', 30); // TENBS
            $table->string('gender', 5)->nullable(); // GIOITINH
            $table->string('department_id', 10); // MAKHOA
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};


