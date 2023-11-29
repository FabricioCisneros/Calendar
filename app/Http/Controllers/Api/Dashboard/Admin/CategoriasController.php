<?php

namespace App\Http\Controllers\Api\Dashboard\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\categoria\StoreRequest;
use App\Http\Requests\Dashboard\Admin\categoria\UpdateRequest;
use App\Http\Resources\Categoria\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoriasController extends Controller
{
    public function store(StoreRequest $request): JsonResponse{

        $request->validated();
        $categoria = new Categoria();
        $categoria->name=$request->get('name');
        $categoria->color=$request->get('color');

        if($categoria->save()){
            return response()->json(['message' => 'Data saved correctly', 'label' => new CategoriaResource($categoria)]);
        }else{
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
    }

    
    public function index(): JsonResponse
    {
        return response()->json(CategoriaResource::collection(Categoria::all()));
    }

    public function show(Categoria $categoria): JsonResponse
    {
        return response()->json(new CategoriaResource($categoria));
    }

    public function update(UpdateRequest $request, Categoria $categoria): JsonResponse
    {
        $request->validated();
        $categoria->name = $request->get('name');
        $categoria->color=$request->get('color');
        if ($categoria->save()) {
            return response()->json(['message' => '', 'categoria' => new CategoriaResource($categoria)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
    public function destroy(Categoria $categoria): JsonResponse
    {
        if ($categoria->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }
}
