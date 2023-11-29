<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendario extends Model
{
    use HasFactory,Filterable;
    protected $table = 'calendario';
    protected $cast=[
        'agent_id'=> 'integer',
        'actividad_id'=>'integer',
        'status_id'=>'integer'
    ];

    public function agent():BelongsTo{
        return $this->belongsTo(Personal::class);
    }

    public function actividad():BelongsTo{
        return $this->belongsTo(Activity::class); 
    }

    public function status():BelongsTo{
        return $this->belongsTo(Status::class);
    }
}
