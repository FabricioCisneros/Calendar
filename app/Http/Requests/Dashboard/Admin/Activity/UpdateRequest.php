<?php

namespace App\Http\Requests\Dashboard\Admin\Activity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'tittle' => ['required', 'max:255'],
            'Desc'=>['required', 'max:255'],
            'categoria_id'=>['required']
        ];
    }

    public function messages(){
        return[
        'tittle.required' => __('el campo :attribute es requerido', ['attribute' => __('titulo de la actividad')]),
        'tittle.max' => __('el campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('titulo de la actividad'), 'max' => 255]),

        'Desc.required' => __('el campo :attribute es requerido', ['attribute' => __('Descripcion de la actividad')]),
        'Desc.max' => __('el campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('Descripcion de la actividad'), 'max' => 255])
        ];
    }
}
