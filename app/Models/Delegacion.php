<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegacion extends Model
{
    protected $connection='conexion_nominas';
    protected $table='delegaciones';
    protected $keyType = 'string'; // Indica que la clave primaria es una cadena
    protected $primaryKey = 'id';
    use HasFactory;
}
