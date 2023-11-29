<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory,Filterable;

    protected $casts = [
        'categoria_id' => 'integer',
    ];

    public function categoria():BelongsTo
    {
     return $this->belongsTo(Categoria::class);
    }
}
