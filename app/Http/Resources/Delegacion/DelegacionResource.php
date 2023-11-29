<?php

namespace App\Http\Resources\Delegacion;

use Illuminate\Http\Resources\Json\JsonResource;

class DelegacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $delegacion=$this;
       return[
            'id' => (string)$delegacion->id, // Asegura que se devuelva como cadena
            'descripcion'=>$delegacion->descripcion
       ];

    }
}
