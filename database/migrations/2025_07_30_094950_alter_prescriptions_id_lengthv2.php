<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // B1: Gỡ ràng buộc foreign key ở bảng detail_prescription
        Schema::table('detail_prescription', function (Blueprint $table) {
            $table->dropForeign('detail_prescription_prescription_id_foreign');
        });

        // B2: Đổi kiểu dữ liệu cột id của bảng prescriptions
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('id', 30)->change();
        });

        // B3: Đổi kiểu dữ liệu prescription_id để khớp
        Schema::table('detail_prescription', function (Blueprint $table) {
            $table->string('prescription_id', 30)->change();

            // Thêm lại foreign key nếu muốn (không bắt buộc)
            $table->foreign('prescription_id')
                ->references('id')->on('prescriptions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Gỡ foreign key mới
        Schema::table('detail_prescription', function (Blueprint $table) {
            $table->dropForeign(['prescription_id']);
        });

        // Trả kiểu dữ liệu id và prescription_id về lại ban đầu (giả sử là integer)
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->integer('id')->change();
        });

        Schema::table('detail_prescription', function (Blueprint $table) {
            $table->integer('prescription_id')->change();

            // Thêm lại foreign key cũ nếu cần
            $table->foreign('prescription_id')
                ->references('id')->on('prescriptions')
                ->onDelete('cascade');
        });
    }
};
