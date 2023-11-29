<?php

namespace App\Http\Resources\Categoria;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $categoria = $this;
        return [
            'id' => $categoria->id,
            'name' => $categoria->name,
            'color'=> $categoria->color,
            'created_at' => $categoria->created_at->toISOString()
        ];
    }
}
