<?php

namespace App\Http\Resources\turno;

use Illuminate\Http\Resources\Json\JsonResource;

class TurnoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $turno=$this;

        return[
            'id'=>$turno->id,
            'descripcion'=>$turno->descripcion
        ];
    }
}
