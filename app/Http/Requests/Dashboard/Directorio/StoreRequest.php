<?php

namespace App\Http\Requests\Dashboard\Directorio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empleado_id'=>['required'],
            'ticket_id'=>['required'],
            'fecha_asignacion'=>['required', 'date', 'before_or_equal:' . Carbon::now()->format('Y-m-d')],
            
        ];
    }

    public function messages()
    {
        return[
            'empleado_id.required'=>__('No se selecciono ningun :attribute ',['attribute'=>__('empleado')]),
            'ticket_id.is.required'=>__('No se selecciono ningun :attribute',['attribute'=>__('equipo')]),
            'fecha_asignacion.required' => __('No se seleccionó ninguna fecha, ingresa la fecha en que se entregó el equipo'),
            'fecha_asignacion.date' => __('El campo :attribute debe ser una fecha válida',['attribute'=>__('fecha')]),
            'fecha_asignacion.before_or_equal' => __('El campo :attribute no puede ser mayor a la fecha actual',['attribute'=>__('fecha')]),
        
        ];
    }
}
