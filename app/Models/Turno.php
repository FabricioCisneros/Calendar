<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $connection='conexion_nominas';
    protected $table = 'turnos';
    use HasFactory;
}
