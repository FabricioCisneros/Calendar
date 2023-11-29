<?php

namespace App\Http\Resources\Dashboard\Admin\Activity;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreRequest extends JsonResource
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
