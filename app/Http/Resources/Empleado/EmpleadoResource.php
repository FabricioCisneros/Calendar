<?php

namespace App\Http\Resources\Empleado;

use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\turno\TurnoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $empleado=$this;
        return[
            'id'=>$empleado->id,
            'name'=>$empleado->name,
            'apellidos'=>$empleado->apellidos,
            'email'=>$empleado->email,
            'telefono'=>$empleado->telefono,
            'oficina_id'=>$empleado->oficina_id,
            'oficina'=>new OficinaResource($empleado->oficina),
            'turno'=>new TurnoResource($empleado->turno),
            'turno_id'=>$empleado->turno_id,
        ];
    }
}
