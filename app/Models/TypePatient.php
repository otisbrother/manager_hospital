<?php

// app/Models/TypePatient.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePatient extends Model
{
    protected $table = 'type_patients';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'code'];
}

?>

