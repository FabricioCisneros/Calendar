<?php

namespace App\Http\Resources\Calendario;

use App\Http\Resources\Activity\ActivityResource;
use App\Http\Resources\personal\PersonalResource;
use App\Http\Resources\Status\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $calendario = $this;
        return[
            'id'=>$calendario->id,
            'agent_id'=>$calendario->agent_id,
            'agent'=>new PersonalResource($calendario->agent),
            'actividad_id'=>$calendario->actividad_id,
            'actividad'=>new ActivityResource($calendario->actividad),
            'fecha_appointment'=>$calendario->fecha_appointment,
            'status_id'=>$calendario->status_id,
            'status'=>new StatusResource($calendario->status),

        ];
    }
}
