<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insurance_applications', function (Blueprint $table) {
            $table->boolean('admin_notified')->default(false)->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('insurance_applications', function (Blueprint $table) {
            $table->dropColumn('admin_notified');
        });
    }
}; 