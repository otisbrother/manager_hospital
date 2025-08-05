<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discharge extends Model
{
    protected $table = 'discharge';
    protected $primaryKey = ['patient_id', 'discharge_date'];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'patient_id',
        'discharge_date',
        'discharge_reason',
        'treatment_result',
        'follow_up_instructions',
    ];

    protected $casts = [
        'discharge_date' => 'date',
    ];

    // Thiết lập quan hệ
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
