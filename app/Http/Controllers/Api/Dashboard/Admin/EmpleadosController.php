<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Empleado\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Empleado\UpdateRequest;
use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\Empleado\EmpleadoResource;
use App\Http\Resources\Empleado\EmpleadoListResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\turno\TurnoResource;
use App\Models\Empleado;
use App\Models\Oficina;
use App\Models\Turno;
use Composer\XdebugHandler\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmpleadosController extends Controller
{
    public function store(StoreRequest $request):JsonResponse{
        $request->validated();
        $empleado=new Empleado();
        $empleado->name=$request->get('name');
        $empleado->apellidos=$request->get('apellidos');
        $empleado->email=$request->get('email');
        $empleado->telefono=$request->get('telefono');
        $empleado->oficina_id=$request->get('oficina_id');
        $empleado->turno_id=$request->get('turno_id');

        if($empleado->save()){
            return response()->json(['empleado'=>new EmpleadoResource($empleado)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

  


    public function index(Request $request):JsonResponse
    {
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        if (!array_key_exists('column', $sort)) {
            $sort['column'] = 'created_at'; // valor predeterminado si la clave 'column' no está presente
        }
        $items = Empleado::filter($request->all())
                ->orderBy($sort['column'], $sort['order'])
                ->paginate((int) $request->get('perPage', 10));
        
        return response()->json([
            'items'=>EmpleadoListResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    public function show(Empleado $empleado):JsonResponse
    {
        return response()->json(new EmpleadoResource($empleado));
    }

    public function update(UpdateRequest $request, Empleado $empleado):JsonResponse
    {
        $request->validated();
        $empleado->name  =$request->get('name');
        $empleado->apellidos=$request->get('apellidos');
        $empleado->email =$request->get('email');
        $empleado->telefono =$request->get('telefono');
        $empleado->oficina_id =$request->get('oficina_id');
        $empleado->turno_id =$request->get('turno_id');
        
        if($empleado->save()){
            return response()->json(['message'=>'datos actualizados', 'user'=>new EmpleadoResource($empleado)]);
        }
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        
    }

    public function filters(): JsonResponse
    {
        return response()->json([
            'oficinas'=>OficinaResource::collection(Oficina::all()),
            'turnos'=>TurnoResource::collection(Turno::all())
        ]);
    }

}
