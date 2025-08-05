<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = 'medical_records';

    protected $primaryKey = ['id', 'order'];
    public $incrementing = false; // vì không phải id tự tăng
    protected $keyType = 'string';

    protected $fillable = ['id', 'order'];

    public $timestamps = true;

    // Bắt buộc override nếu dùng khóa chính kép
    public function getKeyName()
    {
        return null;
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}


?>