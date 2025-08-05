<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailMedicalRecord extends Model
{
    protected $table = 'detail_medicalrecords';
    public $incrementing = false;
    protected $primaryKey = ['medical_record_id', 'patient_id', 'exam_date'];
    protected $keyType = 'string';

    protected $fillable = [
        'medical_record_id',
        'patient_id',
        'exam_date',
        'prescription_id',
        'disease_name',
        'department_id',
    ];

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('medical_record_id', $this->medical_record_id)
                     ->where('patient_id', $this->patient_id)
                     ->where('exam_date', $this->exam_date);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
