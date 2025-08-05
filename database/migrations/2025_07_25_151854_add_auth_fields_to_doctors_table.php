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
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'email')) {
                $table->string('email')->unique()->after('name');
            }
            if (!Schema::hasColumn('doctors', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            if (!Schema::hasColumn('doctors', 'password')) {
                $table->string('password')->after('email_verified_at');
            }
            if (!Schema::hasColumn('doctors', 'remember_token')) {
                $table->rememberToken()->after('password');
            }
            if (!Schema::hasColumn('doctors', 'phone')) {
                $table->string('phone', 15)->nullable()->after('gender');
            }
            if (!Schema::hasColumn('doctors', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('doctors', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('address');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'email', 
                'email_verified_at', 
                'password', 
                'remember_token',
                'phone',
                'address', 
                'status'
            ]);
        });
    }
};
