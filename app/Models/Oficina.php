<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Oficina extends Model
{
    protected $connection='conexion_nominas';
    protected $table = 'oficina';
    
    use HasFactory;

}
