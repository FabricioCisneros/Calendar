<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Label\LabelSelectResource;
use App\Http\Resources\NumeroSerie\NumeroSerieResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Priority\PriorityResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\TicketReply\TicketReplyQuickDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketListResource extends JsonResource
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
            'id'=>$ticket->id,
            'uuid'=>$ticket->uuid,
            'status' => new StatusResource($ticket->status),
            'numero_serie'=>$ticket->numero_serie,
            'modelo'=>$ticket->modelo,
            'body' => $ticket->body,
            'categoria'=>new CategoriaResource($ticket->categoria),
            'oficina'=>new OficinaResource($ticket->oficina),
        ];
    }
}
