<?php

namespace App\Http\Requests\Dashboard\Admin\Empleado;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

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
            'oficina_id' => ['required', 'exists:oficinas,id'],
            'name'=>['required','max:255'],
            'apellidos'=>['required','max:255'],
            'email'=>['nullable', 'max:255', Rule::unique('empleados')->whereNull('email')],
            'telefono'=>['nullable', 'max:255', Rule::unique('empleados')->whereNull('telefono')],                
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('El campo :attribute es requerido', ['attribute' => __('name')]),
            'name.max' => __('El campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('name'), 'max' => 255]),

            'apellido.required' => __('El campo :attribute es requerido', ['attribute' => __('apellido')]),
            'apellido.max' => __('El campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('apellido'), 'max' => 255]),


            'email.max' => __('El campo :attribute no debe ser mayor a :max carcateres', ['attribute' => __('email'), 'max' => 255]),
            'email.unique' => __('El campo :attribute ya esta en uso', ['attribute' => __('email')]),

            'telefono.max'=>__('El campo :attribute no debe ser mayor a :max carcateres', ['attribute' => __('telefono'), 'max' => 255]),
            'telefono.unique'=>__('El campo :attribute ya esta en uso', ['attribute' => __('telefono')]),
            
            'oficina_id.required' => __('El campo :attribute es necesario', ['attribute' => __('oficina')]),
            'oficina_id.exists' => __('El campo :attribute es invalido', ['attribute' => __('oficina')]),
        ];
    }
}
