<?php

namespace App\Http\Requests\Dashboard\Admin\Personal;

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
     */ public function rules()
    {
        return [
            'nombre' => ['required', 'max:255'],
            'correo' => ['required', 'email', 'max:255', 'unique:personal,correo,'.$this->get('id')],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => __('The :attribute field is required', ['attribute' => __('nombre')]),
            'nombre.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('nombre'), 'max' => 255]),

            'correo.required' => __('The :attribute field is required', ['attribute' => __('correo')]),
            'correo.email' => __('The :attribute must be a valid email address', ['attribute' => __('correo')]),
            'correo.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('correo'), 'max' => 255]), 
            'correo.unique' => __('The :attribute has already been taken', ['attribute' => __('correo')]),
        ];
    }
}
