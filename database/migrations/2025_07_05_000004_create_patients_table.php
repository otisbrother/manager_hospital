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
        Schema::create('patients', function (Blueprint $table) {
            $table->string('id', 10)->primary(); // MABN

            // MALBN (foreign key -> type_patients.id)
            $table->string('patient_type_id', 10)->nullable();

            // MABHYT (foreign key -> health_insurances.id)
            $table->string('insurance_id', 15)->nullable()->unique();

            $table->string('name', 30);        // TENBN
            $table->string('gender', 5)->nullable();    // GIOITINH
            $table->date('date')->nullable();           // NGAYSINH
            $table->string('address', 255)->nullable(); // DIACHI
            $table->string('phone', 10)->nullable();    // SDT
            $table->timestamps();

            // Foreign keys (ràng buộc khóa ngoại)
            $table->foreign('patient_type_id')
                ->references('id')
                ->on('type_patients')
                ->nullOnDelete(); // nếu xoá loại bệnh nhân thì patient_type_id => null

            // $table->foreign('insurance_id')
            //     ->references('id')
            //     ->on('health_insurance')
            //     ->nullOnDelete(); // nếu xoá BHYT thì insurance_id => null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
