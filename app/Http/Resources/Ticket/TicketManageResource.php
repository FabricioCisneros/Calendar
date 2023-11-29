<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Label\LabelSelectResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Priority\PriorityResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\TicketReply\TicketReplyDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketManageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Ticket $ticket */
        $ticket = $this;
        return [
            'id' => $ticket->id,
            'uuid' => $ticket->uuid,
            'modelo'=>$ticket->modelo,
            'numero_serie'=>$ticket->numero_serie,
            'body'=>$ticket->body,
            'status' => new StatusResource($ticket->status),
            'status_id' => $ticket->status_id,
            'categoria_id'=>$ticket->categoria_id,
            'categoria'=>new CategoriaResource($ticket->categoria),
            'oficina_id'=>$ticket->oficina_id,
            'oficina'=>new OficinaResource($ticket->oficina),
            'created_at' => $ticket->created_at->toISOString(),
            'updated_at' => $ticket->updated_at->toISOString(),
            'ticketReplies' => TicketReplyDetailsResource::collection($ticket->ticketReplies()->orderByDesc('created_at')->get()),
        ];

        // return[
        //     'id'=>$ticket->id,
        //     'uuid'=>$ticket->uuid,
        //     
        //     '
        //     'body'=>$ticket->body,
        //     'status_id'=>$ticket->status_id,
        //     'status'=>new StatusResource($ticket->status),
        //     
        //     
        //     
        //     
        //     'ticketReplies' => TicketReplyDetailsResource::collection($ticket->ticketReplies()->orderByDesc('created_at')->get()),
        //     'updated_at' => $ticket->updated_at->toISOString(),
        // ];
    }
}
