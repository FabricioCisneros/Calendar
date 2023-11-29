<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\File\FileController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Ticket\StoreRequest;
use App\Http\Requests\Dashboard\Ticket\TicketReplyRequest;
use App\Http\Requests\Dashboard\Ticket\UpdateRequest;
use App\Http\Requests\File\StoreFileRequest;

use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Label\LabelSelectResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Priority\PriorityResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\Ticket\TicketListResource;
use App\Http\Resources\Ticket\TicketManageResource;
use App\Http\Resources\User\UserDetailsResource;

use App\Models\Categoria;
use App\Models\Department;
use App\Models\Label;
use App\Models\Oficina;
use App\Models\Priority;
use App\Models\Setting;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\Ticket\NewTicketFromAgent;
use App\Notifications\Ticket\NewTicketReplyFromAgentToUser;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;
use Throwable;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws Exception*/
     public function index(Request $request): JsonResponse
    {
        /** @var User $user */

        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        if (!array_key_exists('column', $sort)) {
            $sort['column'] = 'created_at'; // valor predeterminado si la clave 'column' no está presente
        }    
        $items = Ticket::filter($request->all())
                ->orderBy($sort['column'], $sort['order'])
                ->paginate((int) $request->get('perPage', 10));
        
        return response()->json([
            'items' => TicketListResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $request->validated();
        $ticket = new Ticket();
        $ticket->uuid = Str::uuid();
        $ticket->modelo = $request->get('modelo');
        $ticket->numero_serie=$request->get('numero_serie');
        $ticket->body = $request->get('body');
        $ticket->status_id = $request->get('status_id');
        $ticket->categoria_id = $request->get('categoria_id');
        $ticket->oficina_id = $request->get('oficina_id');
        $ticket->saveOrFail();

        $ticketReply = new TicketReply();
        $ticketReply->user_id = Auth::id();
        $ticketReply->body = $request->get('body');
        
        if ($ticket->ticketReplies()->save($ticketReply)) {
            if ($request->has('attachments')) {
                $ticketReply->ticketAttachments()->sync(collect($request->get('attachments'))->map(function ($attachment) {
                    return $attachment['id'];
                }));
            }
            
            return response()->json(['ticket' => new TicketManageResource($ticket)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
    public function update(UpdateRequest $request, Ticket $ticket):JsonResponse{

        $request->validated();
        $ticket->uuid = Str::uuid();
        $ticket->modelo=$request->get('modelo');
        $ticket->numero_serie=$request->get('numero_serie');
        $ticket->status_id=$request->get('status_id');
        $ticket->categoria_id=$request->get('categoria_id');
        $ticket->oficina_id=$request->get('oficina_id');
        if($ticket->save()){
            return response()->json(['message' => 'Data updated correctly', 'user' => new TicketManageResource($ticket)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
    /**
     * Display the specified resource.
     *
     * @param  Ticket  $ticket
     * @return JsonResponse
     */
    public function show(Ticket $ticket): JsonResponse
    {
        /** @var User $user */
        
        return response()->json(new TicketManageResource($ticket));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TicketReplyRequest  $request
     * @param  Ticket  $ticket
     * @return JsonResponse
     */
    public function reply(Ticket $ticket, TicketReplyRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$ticket->verifyUser($user)) {
            return response()->json(['message' => __('You do not have permissions to manage this ticket')], 403);
        }
        $request->validated();
        $ticketReply = new TicketReply();
        $ticketReply->user_id = Auth::id();
        $ticketReply->body = $request->get('body');
        if ($ticket->ticketReplies()->save($ticketReply)) {
            if ($request->has('attachments')) {
                $ticketReply->ticketAttachments()->sync(collect($request->get('attachments'))->map(function ($attachment) {
                    return $attachment['id'];
                }));
            }
            $ticket->status_id = $request->get('status_id');
            $ticket->updated_at = Carbon::now();
            $ticket->save();
            return response()->json(['message' => __('Detalle aplicado al equipo'), 'ticket' => new TicketManageResource($ticket)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ticket  $ticket
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Ticket $ticket): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$ticket->verifyUser($user)) {
            return response()->json(['message' => __('You do not have permissions to manage this ticket')], 403);
        }
        $ticket->labels()->sync([]);
        foreach ($ticket->ticketReplies()->get() as $ticketReply) {
            $ticketReply->ticketAttachments()->sync([]);
        }
        $ticket->ticketReplies()->delete();
        if ($ticket->delete()) {
            return response()->json(['message' => 'Equipo eliminado']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }

    public function filters(): JsonResponse
    {
        return response()->json([
            'statuses' => StatusResource::collection(Status::all()),
            'oficinas'=>OficinaResource::collection(Oficina::all()),
            'categorias'=>CategoriaResource::collection(Categoria::all())
        ]);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function quickActions(Request $request): JsonResponse
    {
        $action = $request->get('action');
        /** @var User $user */
        $tickets = Ticket::whereIn('id', $request->get('tickets'));
        
        if ($tickets->count() < 1) {
            return response()->json(['message' => __('You have not selected a ticket or do not have permissions to perform this action')], 403);
        }
        if ($action === 'delete') {
            foreach ($tickets->get() as $ticket) {
                /** @var Ticket $ticket */
                $ticket->delete();
            }
            return response()->json(['message' => __('El equipo seleccionado fue eliminado')]);
        }
        return response()->json(['message' => __('Hubo un problema al procesar la accion')], 404);
    }

    /**
     * @param  Ticket  $ticket
     * @param  Request  $request
     * @return JsonResponse
     * @throws Throwable
     */


    public function uploadAttachment(StoreFileRequest $request): JsonResponse
    {
        return (new FileController())->uploadAttachment($request);
    }
}
