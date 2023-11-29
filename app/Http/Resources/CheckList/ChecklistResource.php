<?php

namespace App\Http\Resources\CheckList;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $checklist=$this;

        return[
            'id'=>$checklist->id,
            'name'=>$checklist->name,
            'desc'=>$checklist->desc
        ];

    }
}
