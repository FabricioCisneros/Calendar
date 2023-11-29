<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Activity\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Activity\UpdateRequest;
use App\Http\Resources\Activity\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function store(StoreRequest $request):JsonResponse{
        
        $request->validated();
        $activity=new Activity();
        $activity->tittle=$request->get('tittle');
        $activity->Desc=$request->get('Desc');
        $activity->categoria_id=$request->get('categoria_id');

        if($activity->save()){
            return response()->json(['message' => 'Data saved correctly', 'label' => new ActivityResource($activity)]);
        }else{
            return response()->json(['message' => __('An error occurred while saving data')], 500);
        }
    }


    // public function index():JsonResponse{
    //     return response()->json(ActivityResource::collection(Activity::all()));
    // }

    public function index(Request $request):JsonResponse{
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        if (!array_key_exists('column', $sort)) {
            $sort['column'] = 'created_at'; // valor predeterminado si la clave 'column' no está presente
        }
        
        $items=Activity::filter($request->all())
        ->orderBy($sort['column'], $sort['order'])
        ->paginate((int) $request->get('perPage', 10));


        return response()->json([
            'items'=>ActivityResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    public function show(Activity $activity):JsonResponse{
        return response()->json(new ActivityResource($activity));
    }

    public function update(UpdateRequest $request, Activity $activity): JsonResponse{
        $request->validated();
        $activity->tittle=$request->get('tittle');
        $activity->Desc=$request->get('Desc');
        $activity->categoria_id=$request->get('categoria_id');

        if($activity->save()){ 
            return response()->json(['message'=> '', 'actividad'=>new ActivityResource($activity)]);
        }
        return response()->json(['message'=> __('Ocurrio un error al actualizar los datos')], 500);
    }
    
    public function destroy(Activity $activity){
        if ($activity->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }
}
