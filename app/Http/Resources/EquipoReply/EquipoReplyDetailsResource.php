<?php

namespace App\Http\Resources\EquipoReply;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipoReplyDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $equipoReply=$this;
       return [
        'id' => $equipoReply->id,
        'user' => new UserDetailsResource($equipoReply->user),
        'body' => preg_replace("/<a(.*?)>/", "<a$1 target=\"_blank\">", $equipoReply->body),
        'created_at' => $equipoReply->created_at->toISOString(),
        'attachments' => FileResource::collection($equipoReply->equipoAttachments)
    ];
    }
}
