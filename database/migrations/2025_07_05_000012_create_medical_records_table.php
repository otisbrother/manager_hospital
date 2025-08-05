<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->string('id', 30); // MASKB
            $table->integer('order'); // STT
            $table->timestamps();

            $table->primary(['id', 'order']); // Khóa chính kép
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};