<?php

namespace App\Http\Resources\Directorio;

use App\Http\Resources\Empleado\EmpleadoResource;
use App\Http\Resources\Equipos\EquipoManageResource;
use App\Http\Resources\Nomina\NominaResource;
use App\Http\Resources\Ticket\TicketManageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectorioListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $directorio =$this;

        return[
            'id'=>$directorio->id,
            'nomina'=>new NominaResource($directorio->nomina),
            'equipo'=>new EquipoManageResource($directorio->equipo),
            'nomina_id'=>$directorio->nomina->id,
            'equipo_id'=>$directorio->equipo->id,
            'fecha_asignacion'=>$directorio->fecha_asignacion,
            'fecha_baja'=>$directorio->fecha_baja,
            'estatus_directorio'=>$directorio->estatus_directorio
        ];
    }
}
