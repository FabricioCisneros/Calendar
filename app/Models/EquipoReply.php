<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EquipoReply extends Model
{
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipo():BelongsTo{
        return $this->belongsTo(Equipo::class);
    }

    public function equipoAttachments():BelongsToMany
    {
        return $this->belongsToMany(File::class, 'equipo_attachments');
    }
}
