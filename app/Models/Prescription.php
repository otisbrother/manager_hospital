<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';
    protected $primaryKey = 'id';
    public $incrementing = false; // vì id là string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'doctor_id',
        'patient_id',
    ];

    // Quan hệ với bác sĩ
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Quan hệ với bệnh nhân
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Quan hệ với chi tiết đơn thuốc
    public function details()
    {
        return $this->hasMany(DetailPrescription::class);
    }

    // Quan hệ với thuốc thông qua detail_prescriptions
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'detail_prescriptions', 'prescription_id', 'medicine_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
