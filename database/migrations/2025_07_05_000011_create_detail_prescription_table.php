<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_prescription', function (Blueprint $table) {
            $table->string('prescription_id', 10); // MADT
            $table->string('medicine_id', 10);     // MATHUOC
            $table->integer('quantity')->default(1); // SONGAYUONG

            // Khóa chính kết hợp
            $table->primary(['prescription_id', 'medicine_id']);

            // Khóa ngoại
            $table->foreign('prescription_id')
                ->references('id')->on('prescriptions')
                ->onDelete('cascade');

            $table->foreign('medicine_id')
                ->references('id')->on('medicines')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_prescription');
    }
};
