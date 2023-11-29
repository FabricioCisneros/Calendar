<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nomina\NominaResource;
use App\Filters\NominaFilter;
use App\Models\Nomina;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class NominaController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum');
        $this->middleware('demo',['only'=>['store','update', 'destroy']]);
    }

    public function index(Request $request):JsonResponse
    {
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'nombre'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        if (!array_key_exists('column', $sort)) {
            $sort['column'] = 'nombre'; // valor predeterminado si la clave 'column' no está presente
        }
        
        $items = Nomina::on('conexion_nominas')
                        ->filter($request->all(), NominaFilter::class) // Aplicar los filtros
                        ->orderBy($sort['column'], $sort['order']) // Aplicar ordenación
                        ->paginate((int)$request->get('perPage', 10));

        return response()->json([
            'items'=>NominaResource::collection($items->items()),
            'pagination'=>[
                'currentPage'=>$items->currentPage(),
                'perPage'=>$items->perPage(),
                'total'=>$items->total(),
                'totalPages'=>$items->lastPage()
            ]
        ]);
        // return response()->json(NominaResource::collection($items));
    }
}
