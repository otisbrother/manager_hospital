<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'department_id',
        'appointment_date',
        'symptoms',
        'status',
        'notes',
        'admin_notified',
    ];

    // 🔁 Quan hệ với bệnh nhân
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    // 🔁 Quan hệ với bác sĩ
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    // 🔁 Quan hệ với khoa
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
