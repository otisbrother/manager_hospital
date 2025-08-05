<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_medicalrecords', function (Blueprint $table) {
            $table->string('prescription_id', 30)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('detail_medicalrecords', function (Blueprint $table) {
            $table->string('prescription_id', 10)->nullable()->change();
        });
    }
};