<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospitalized extends Model
{
    protected $table = 'hospitalized';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'patient_id',
        'admission_date',
        'room',
        'bed',
        'reason',
        'diagnosis',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function discharge()
    {
        return $this->hasOne(Discharge::class, 'patient_id', 'patient_id');
    }
}
