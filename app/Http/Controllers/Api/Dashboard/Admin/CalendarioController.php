<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Calendario\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Calendario\UpdateRequest;
use App\Http\Resources\Calendario\CalendarioResource;

use App\Models\Calendario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    
    public function store(StoreRequest $request){
        $request->validated();
        $calendario=new Calendario();
        $calendario->agent_id = $request->get('agent_id');
        $calendario->actividad_id = $request->get('actividad_id');
        $calendario->status_id=3;
        $calendario->fecha_appointment = $request->get('dateAppointment');

        if($calendario->save()){
            return response()->json(['message' => __('Se añadio un nuevo usuario'), 'calendario' => new CalendarioResource($calendario)]);
        }
        return response()->json(['message' => __('Ocurrio un error al añadir al usuario')], 500);

    }

    public function index():JsonResponse
    {
        return response()->json(CalendarioResource::collection(Calendario::all()));
    }

    public function show(Calendario $calendario):JsonResponse
    {
        return response()->json(new CalendarioResource($calendario));
    }

    public function destroy(Calendario $calendario): JsonResponse
    {
        if ($calendario->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }

    public function update( UpdateRequest $request, Calendario $calendario): JsonResponse
    {
        $request->validated();
        
        $calendario->agent_id = $request->get('agent_id');
        $calendario->actividad_id = $request->get('actividad_id');
        $calendario->status_id = $request->get('status_id');
        $calendario->fecha_appointment = $request->get('fecha_appointment');
       
    
        if ($calendario->save()) {
            return response()->json(['message' => '', 'calendario' => new CalendarioResource($calendario)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
}
