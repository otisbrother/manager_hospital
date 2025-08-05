<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->string('id', 10)->primary(); // MATHUOC
            $table->string('name', 100); // TENTHUOC
            $table->string('usage', 200)->nullable(); // CONGDUNG
            $table->string('unit', 50)->nullable(); // DONVITINH
            $table->date('expiry_date')->nullable(); // HANSUDUNG
            $table->decimal('price', 15, 2)->nullable(); // GIATIEN
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};