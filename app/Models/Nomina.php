<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nomina extends Model
{
    protected $table='nomina';
    protected $connection='conexion_nominas';
    use HasFactory, Filterable;

    public function oficina():BelongsTo
    {
     return $this->belongsTo(Oficina::class);
    }
}
