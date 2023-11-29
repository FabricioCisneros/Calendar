<?php

namespace App\Http\Resources\Nomina;

use Illuminate\Http\Resources\Json\JsonResource;

class NominaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $nomina=$this;

       return[
        'id'=>$nomina->id,
        'nombre'=>$nomina->nombre,
        'noempleado'=>$nomina->noempleado,
        'oficina'=>$nomina->oficina,
        'edo'=>$nomina->edo,
        'turno'=>$nomina->turno
       ];
    }
}
