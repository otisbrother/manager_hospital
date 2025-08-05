<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_insurance', function (Blueprint $table) {
            $table->string('id', 15)->primary(); // MABHYT
            $table->date('register_date')->nullable(); // NGAYDK
            $table->date('expire_date')->nullable(); // NGAYHD
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_insurance');
    }
};