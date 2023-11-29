<?php

namespace App\Http\Resources\personal;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $personal=$this;

        return [
            'id' => $personal->id,
            'nombre' => $personal->nombre,
            'correo' => $personal->correo,
            'created_at' => $personal->created_at->toISOString(),
            'updated_at' => $personal->updated_at->toISOString()
        ];
    }
}
