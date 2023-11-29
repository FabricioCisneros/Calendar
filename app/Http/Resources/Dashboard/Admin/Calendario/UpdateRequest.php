<?php

namespace App\Http\Resources\Dashboard\Admin\Calendario;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdateRequest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
