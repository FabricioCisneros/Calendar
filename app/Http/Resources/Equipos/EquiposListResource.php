<?php

namespace App\Http\Resources\Equipos;

use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Status\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquiposListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $equipos=$this;
        return [
            'id'=>$equipos->id,
            'uuid'=>$equipos->uuid,
            'status' => new StatusResource($equipos->status),
            'numero_serie'=>$equipos->numero_serie,
            'modelo'=>$equipos->modelo,
            'body' => $equipos->body,
            'categoria'=>new CategoriaResource($equipos->categoria),
            'oficina'=>new OficinaResource($equipos->oficina),
        ];
    }
}
