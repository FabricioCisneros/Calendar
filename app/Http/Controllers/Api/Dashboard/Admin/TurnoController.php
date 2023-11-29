<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Turno\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Turno\UpdateRequest;
use App\Http\Resources\turno\TurnoResource;
use App\Models\Turno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TurnoController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(TurnoResource::collection(Turno::all()));
    }
    

}
