<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';

    protected $fillable = [
        'id', 'name', 'usage', 'unit', 'expiry_date', 'price',
    ];

    public $incrementing = false; // do khoá chính là string

    protected $keyType = 'string';
}
