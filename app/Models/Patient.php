<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\InsuranceApplication;
use App\Models\DetailMedicalRecord;
use App\Models\Hospitalized;
use App\Models\Discharge;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Bill;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $primaryKey = 'id';
    public $incrementing = false; // ID là string (BNxxxxx)
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'patient_type_id',
        'insurance_id',
        'name',
        'gender',
        'date',
        'address',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Quan hệ
    public function typePatient()
    {
        return $this->belongsTo(TypePatient::class, 'patient_type_id','code');
    }

    public function insurance()
    {
        return $this->belongsTo(HealthInsurance::class, 'insurance_id');
    }

    public function insuranceApplications()
    {
        return $this->hasMany(InsuranceApplication::class);
    }

    public function latestInsuranceApplication()
    {
        return $this->hasOne(InsuranceApplication::class)->latest();
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }

    public function relatives()
    {
    return $this->hasMany(Relative::class);
     }

    public function detailMedicalRecords()
    {
        return $this->hasMany(DetailMedicalRecord::class, 'patient_id', 'id');
    }

    public function hospitalized()
    {
        return $this->hasMany(Hospitalized::class, 'patient_id', 'id');
    }

    public function discharges()
    {
        return $this->hasMany(Discharge::class, 'patient_id', 'id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id', 'id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id', 'id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'patient_id', 'id');
    }

    // Mutator để tự động hash password
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }


}
