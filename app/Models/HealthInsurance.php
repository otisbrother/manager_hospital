<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthInsurance extends Model
{
    // Tên bảng rõ ràng vì không theo chuẩn mặc định Laravel (không có 's')
    protected $table = 'health_insurance';

    // Khóa chính là chuỗi, không phải số tự tăng
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Cho phép gán giá trị hàng loạt
    protected $fillable = [
        'id',
        'register_date',
        'expire_date',
        'coverage_percentage',
        'type',
    ];

    // Quan hệ (nếu có bệnh nhân liên kết)
    public function patients()
    {
        return $this->hasMany(Patient::class, 'insurance_id', 'id');
    }

    // Quan hệ với bills
    public function bills()
    {
        return $this->hasMany(Bill::class, 'health_insurance_id', 'id');
    }
}
