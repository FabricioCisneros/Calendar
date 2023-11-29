<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Directorio\StoreRequest;
use App\Http\Resources\Categoria\CategoriaResource;
use App\Http\Resources\Directorio\DirectorioListResource;
use App\Http\Resources\Directorio\DirectorioManageResource;
use App\Http\Resources\Empleado\EmpleadoListResource;
use App\Http\Resources\Equipos\EquiposListResource;
use App\Http\Resources\Oficina\OficinaResource;
use App\Http\Resources\Ticket\TicketListResource;
use App\Http\Resources\turno\TurnoResource;
use App\Models\Categoria;
use App\Models\Directorio;
use App\Models\Empleado;
use App\Models\Equipo;
use App\Models\Ticket;
use App\Models\Oficina;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class DirectorioController extends Controller
{
    



    public function datosEquipo():JsonResponse{

        return response()->json([
            'oficinas'=>OficinaResource::collection(Oficina::all()),
            'categorias'=>CategoriaResource::collection(Categoria::all()),
        ]);
    }

    public function getEquipo(Request $request):JsonResponse
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


    public function getEmpleados(Request $request):JsonResponse
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
    public function updateOficinasList($selectedState):JsonResponse
    {
        $oficinasList=Oficina::where('id_delegacion',$selectedState)->get();
        $oficinasResource=OficinaResource::collection($oficinasList);

        return response()->json(['oficinas'=>$oficinasResource]);
    }

    public function datosEmpleado():JsonResponse
    {
        return response()->json(['turnos'=>TurnoResource::collection(Turno::all()),
                                 'oficinas'=>OficinaResource::collection(Oficina::all()),]);
        
    }

    public function store(StoreRequest $request):JsonResponse{
            $request->validated();
            $directorio = new Directorio();
            $directorio->nomina_id= $request->get('empleado_id');
            $directorio->equipo_id=$request->get('ticket_id');
            $directorio->fecha_asignacion=$request->get('fecha_asignacion');
            $directorio->estatus_directorio=$request->get('estatus_directorio');

           
            if($directorio->save()){
                return response()->json(['directorio'=>new DirectorioManageResource($directorio)]);
            }
            return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
    public function update(Request $request, Directorio $directorio):JsonResponse{
        
        $directorio->nomina_id= $request->get('nomina_id');
        $directorio->equipo_id=$request->get('equipo_id');
        $directorio->fecha_asignacion=$request->get('fecha_asignacion');
        $directorio->estatus_directorio=$request->get('estatus_directorio');

        if($directorio->save()){
            return response()->json(['directorio'=>new DirectorioManageResource($directorio)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
    public function index(Request $request):JsonResponse{
        $sort =json_decode($request->get('sort',json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        
        if (!array_key_exists('column', $sort)) {
            $sort['column'] = 'created_at'; // valor predeterminado si la clave 'column' no está presente
        }

        $items = Directorio::filter($request->all())
        ->orderBy($sort['column'], $sort['order'])
        ->paginate((int) $request->get('perPage', 10));

        return response()->json([
            'items' => DirectorioListResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);



    }
}
