<?php

namespace App\Http\Requests\Dashboard\Admin\Personal;

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
     */ public function rules()
    {
        return [
            'nombre' => ['required', 'max:255'],
            'correo' => ['required', 'email', 'max:255', 'unique:personal'],
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
            'nombre.required' => __('The :attribute field is required', ['attribute' => __('name')]),
            'nombre.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('name'), 'max' => 255]),

            'correo.required' => __('The :attribute field is required', ['attribute' => __('email')]),
            'correo.email' => __('The :attribute must be a valid email address', ['attribute' => __('email')]),
            'correo.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('email'), 'max' => 255]),
            'correo.unique' => __('The :attribute has already been taken', ['attribute' => __('email')]),
        ];
    }
}
