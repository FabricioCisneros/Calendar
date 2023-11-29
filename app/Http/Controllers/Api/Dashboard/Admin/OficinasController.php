<?php

namespace App\Http\Controllers\Api\Dashboard\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Oficina\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Oficina\UpdateRequest;
use App\Http\Resources\Oficina\OficinaResource;
use App\Models\Oficina;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OficinasController extends Controller
{
 
    


    public function index(): JsonResponse
    {
        return response()->json(OficinaResource::collection(Oficina::all()));
    }

}
