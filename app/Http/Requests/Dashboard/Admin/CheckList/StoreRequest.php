<?php

namespace App\Http\Requests\Dashboard\Admin\CheckList;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'=>['required'],
            'desc'=>['required']
        ];
    }

    public function messages(){
        return[
            'name.required'=>__('El :attribute es obligatorio',['attribute'=>__('nombre de la actividad')]),
            'desc.required'=>__('El :attribute es obligatorio', ['attribute'=>__('descripcion de la actividad')])
        ];
    }
}
