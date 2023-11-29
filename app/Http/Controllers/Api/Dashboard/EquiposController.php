<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\File\FileController;
use App\Http\Controllers\Controller;

use App\Http\Requests\Dashboard\Equipo\EquipoReplyRequest;
use App\Http\Requests\Dashboard\Equipo\StoreRequest;
use App\Http\Requests\Dashboard\Equipo\UpdateRequest;
use App\Http\Requests\File\StoreFileRequest;
use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\Equipos\EquipoManageResource;
use App\Http\Resources\Equipos\EquiposListResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Status\StatusResource;
use App\Models\Categoria;
use App\Models\Equipo;
use App\Models\EquipoReply;
use App\Models\Oficina;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;

class EquiposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


    public function index(Request $request): JsonResponse
    {
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        if (!array_key_exists('column', $sort)) {
            $sort['column'] = 'created_at'; // valor predeterminado si la clave 'column' no está presente
        }    
        $items = Equipo::filter($request->all())
                ->orderBy($sort['column'], $sort['order'])
                ->paginate((int) $request->get('perPage', 10));
        
        return response()->json([
            'items' => EquiposListResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    public function show(Equipo $equipo){
        return response()->json(new EquipoManageResource($equipo));
    }

    public function filters(): JsonResponse
    {
        return response()->json([
            'statuses' => StatusResource::collection(Status::all()),
            'oficinas'=>OficinaResource::collection(Oficina::all()),
            'categorias'=>CategoriaResource::collection(Categoria::all())
        ]);
    }
    public function uploadAttachment(StoreFileRequest $request): JsonResponse
    {
        return (new FileController())->uploadAttachment($request);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $request->validated();
        $equipo = new Equipo();
        $equipo->uuid = Str::uuid();
        $equipo->modelo = $request->get('modelo');
        $equipo->numero_serie=$request->get('numero_serie');
        $equipo->body = $request->get('body');
        $equipo->status_id = $request->get('status_id');
        $equipo->categoria_id = $request->get('categoria_id');
        $equipo->oficina_id = $request->get('oficina_id');
        $equipo->saveOrFail();


        $equipoReply=new EquipoReply();
        $equipoReply->user_id = Auth::id();
        $equipoReply->body = $request->get('body');


        if ($equipo->equipoReplies()->save($equipoReply)) {
            if ($request->has('attachments')) {
                $equipoReply->equipoAttachments()->sync(collect($request->get('attachments'))->map(function ($attachment) {
                    return $attachment['id'];
                }));
            }
            
            return response()->json(['equipo' => new EquipoManageResource($equipo)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    public function reply(Equipo $equipo, EquipoReplyRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$equipo->verifyUser($user)) {
            return response()->json(['message' => __('You do not have permissions to manage this ticket')], 403);
        }
        $request->validated();
        $equipoReply = new EquipoReply();
        $equipoReply->user_id = Auth::id();
        $equipoReply->body = $request->get('body');
        if ($equipo->equipoReplies()->save($equipoReply)) {
            if ($request->has('attachments')) {
                $equipoReply->equipoAttachments()->sync(collect($request->get('attachments'))->map(function ($attachment) {
                    return $attachment['id'];
                }));
            }
            $equipo->status_id = $request->get('status_id');
            $equipo->updated_at = Carbon::now();
            $equipo->save();
            return response()->json(['message' => __('Detalle aplicado al equipo'), 'equipo' => new EquipoManageResource($equipo)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    
    public function destroy(Equipo $equipo): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$equipo->verifyUser($user)) {
            return response()->json(['message' => __('You do not have permissions to manage this ticket')], 403);
        }
        $equipo->equipoReplies()->delete();
        if ($equipo->delete()) {
            return response()->json(['message' => 'Equipo eliminado']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }


    public function update(UpdateRequest $request, Equipo $equipo):JsonResponse
    {
        $request->validated();
        $equipo->uuid =Str::uuid();
        $equipo->modelo=$request->get('modelo');
        $equipo->numero_serie=$request->get('numero_serie');
        $equipo->status_id=$request->get('status_id');
        $equipo->categoria_id=$request->get('categoria_id');
        $equipo->oficina_id=$request->get('oficina_id');

        if($equipo->save()){
            return response()->json(['message' => 'Data updated correctly', 'user' => new EquipoManageResource($equipo)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
    
    public function quickActions (Request $request):JsonResponse{

        $action =$request->get('action');
        $equipos=Equipo::whereIn('id',$request->get('equipos'));

        if($equipos->count()>1){
            return response()->json(['message' => __('You have not selected a ticket or do not have permissions to perform this action')], 403);
        }
        if($action==='delete'){
            foreach($equipos->get() as $equipo){
                $equipo->delete();
            }
            return response()->json(['message'=> __('El equipo seleccionado fue eliminado')]);
        }
            return response()->json(['message'=>__('Ocurrio un error al eliminar el equipo')]);


    }

}


