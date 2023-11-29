<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Personal\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Personal\UpdateRequest;
use App\Http\Resources\personal\PersonalResource;
use App\Models\Personal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    public function store(StoreRequest $request):JsonResponse
    {
        $request->validated();
        $personal= new Personal();
        $personal->nombre= $request->get('nombre');
        $personal->correo= $request->get('correo');

        if($personal->save()){
            return response()->json(['message' => __('Se añadio un nuevo usuario'), 'personal' => new PersonalResource($personal)]);
        }
        return response()->json(['message' => __('Ocurrio un error al añadir al usuario')], 500);
    }

    public function index(Request $request):JsonResponse{
        $sort = json_decode($request->get('sort',
                    json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        
        $items = Personal::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json([
            'items' => PersonalResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    public function show(Personal $personal): JsonResponse
    {
        return response()->json(new PersonalResource($personal));
    }

    public function destroy(Personal $personal){
        if($personal->delete()){
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }
    public function update(UpdateRequest $request, Personal $personal): JsonResponse
    {
        $request->validated();
        $personal->nombre = $request->get('nombre');
        $personal->correo = $request->get('correo');
        if ($personal->save()) {
            return response()->json(['message' => 'Data updated correctly', 'user' => new PersonalResource($personal)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
}
