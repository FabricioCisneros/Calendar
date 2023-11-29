<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Directorio extends Model
{
    use HasFactory,Filterable;


    protected $cast=[
        'nomina_id'=>'integer',
        'equipo_id'=>'integer'
    ];

    public function nomina():BelongsTo
    {
        return $this->belongsTo(Nomina::class);
    }

    public function equipo():BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

}
