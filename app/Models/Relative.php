<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relative extends Model
{
    protected $table = 'relative';
   
    // ❗ Cần thêm các dòng này để tránh lỗi `id` không tồn tại
    public $incrementing = false;
    protected $primaryKey = null;

    protected $keyType = 'string';


   

    protected $fillable = [
        'patient_id', 'name', 'gender', 'dob', 'relationship'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}


?>