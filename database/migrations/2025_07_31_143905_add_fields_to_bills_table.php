<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('total');
            $table->timestamp('bill_date')->nullable()->after('status');
            $table->string('payment_method')->nullable()->after('bill_date');
            $table->timestamp('payment_date')->nullable()->after('payment_method');
            $table->text('notes')->nullable()->after('payment_date');
        });
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn(['status', 'bill_date', 'payment_method', 'payment_date', 'notes']);
        });
    }
}; 