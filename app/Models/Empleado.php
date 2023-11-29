<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empleado extends Model
{
    use Filterable, HasFactory;


    protected $casts =[
        'oficina_id'=>'integer',
        'turno_id'=> 'integer'
    ];

    public function oficina():BelongsTo
    {
     return $this->belongsTo(Oficina::class);
    }

    public function turno():BelongsTo
    {
     return $this->belongsTo(Turno::class);
    }


    
}
