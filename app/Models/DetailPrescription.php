<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPrescription extends Model
{
    protected $table = 'detail_prescription';

    public $timestamps = false; // không có created_at, updated_at

    protected $primaryKey = null; // vì dùng khóa chính kết hợp
    public $incrementing = false;

    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'quantity',
        'usage_instructions',
    ];

    // Quan hệ với đơn thuốc
    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }

    // Quan hệ với thuốc
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}
