<?php

namespace App\Http\Resources\Equipos;

use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\EquipoReply\EquipoReplyDetailsResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\TicketReply\TicketReplyDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipoManageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $equipo = $this;
        return [
            'id' => $equipo->id,
            'uuid' => $equipo->uuid,
            'modelo'=>$equipo->modelo,
            'numero_serie'=>$equipo->numero_serie,
            'body'=>$equipo->body,
            'status' => new StatusResource($equipo->status),
            'status_id' => $equipo->status_id,
            'categoria_id'=>$equipo->categoria_id,
            'categoria'=>new CategoriaResource($equipo->categoria),
            'oficina_id'=>$equipo->oficina_id,
            'oficina'=>new OficinaResource($equipo->oficina),
            'created_at' => $equipo->created_at->toISOString(),
            'updated_at' => $equipo->updated_at->toISOString(),
            'equipoReplies' => EquipoReplyDetailsResource::collection($equipo->equipoReplies()->orderByDesc('created_at')->get()),
        ];
    }
}
