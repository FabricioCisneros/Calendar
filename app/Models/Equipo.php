<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    use Filterable, HasFactory;
    
    protected $casts = [
        'status_id' => 'integer',
        'oficina_id' => 'integer',
        'categoria_id' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function oficina():BelongsTo
    {
     return $this->belongsTo(Oficina::class);
    }
 
    public function categoria():BelongsTo
    {
     return $this->belongsTo(Categoria::class);
    }

    public function equipoReplies():HasMany
    {
        return $this->hasMany(EquipoReply::class);
    }

    public function verifyUser(User $user): bool
    {
        if ($user->role_id !== 1) {
            $userId = $user->id;
            return $this->department_id === null || ($this->department->all_agents || $this->department->agent()->pluck('id')->contains($userId)) || ($this->agent_id === null || $this->agent_id === $userId) || $this->closed_by === $userId;
        }
        return true;
    }
}
