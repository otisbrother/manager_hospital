<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'health_insurance_id',
        'patient_id',
        'prescription_id',
        'total',
        'status',
        'bill_date',
        'payment_method',
        'payment_date',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function healthInsurance()
    {
        return $this->belongsTo(HealthInsurance::class, 'health_insurance_id');
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}