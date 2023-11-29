<?php

namespace App\Http\Resources\Activity;

use App\Http\Resources\Categoria\CategoriaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $activity=$this;

        return[
            'id'=>$activity->id,
            'tittle'=>$activity->tittle,
            'Desc'=>$activity->Desc,
            'categoria_id'=>$activity->categoria_id,
            'categoria'=>new CategoriaResource($activity->categoria),
        ];
    }
}
