<?php

namespace App\Http\Resources\Directorio;

use App\Http\Resources\Empleado\EmpleadoResource;
use App\Http\Resources\Ticket\TicketManageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectorioManageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $directorio=$this;


        return[
        'id'=>$directorio->id,
        'empleado_id'=>$directorio->empleado_id,
        'empleado'=>new EmpleadoResource($directorio->empleado),
        'ticket_id'=>$directorio->ticket_id,
        'ticket'=>new TicketManageResource($directorio->ticket),
        'fecha_asignacion'=>$directorio->fecha_asignacion,
        'fecha_baja'=>$directorio->fecha_baja
        ];
    }
}
