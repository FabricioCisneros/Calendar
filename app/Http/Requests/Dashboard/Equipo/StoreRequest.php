<?php

namespace App\Http\Requests\Dashboard\Equipo;

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
            'categoria_id'=>['required'],
            'oficina_id'=>['required'],
            'modelo'=>['required'],
            'numero_serie'=>['required'],
            'status_id'=>['required'],
            'department_id' => ['exclude_if:department_id,null', 'exists:departments,id'],
            'body' => ['required'],
        
        ];
    }

    public function messages()
    {
        return [
            'department_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('department')]),
            'body.required' => __('The :attribute field is required', ['attribute' => __('body')]),
            'status.required'=>__('The :attribute field is required', ['attribute' => __('status')]),
            'categoria_id.required'=>__('The :attribute field is required', ['attribute' => __('categoria_id')]),
            'oficina_id.required'=>__('The :attribute field is required', ['attribute' => __('oficina_id')]),
            'modelo.required'=>__('The :attribute field is required', ['attribute' => __('modelo')]),
            'numero_serie.required'=>__('The :attribute field is required', ['attribute' => __('numero_serie')]),
            'status_id.required'=>__('The :attribute field is required', ['attribute' => __('status_id')]),
            

        ];
    }
}
