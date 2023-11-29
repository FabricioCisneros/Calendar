<?php

namespace App\Http\Requests\Dashboard\Ticket;

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
            'oficina_id' => ['required', 'exists:oficinas,id'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'modelo' => ['required', 'max:255'],
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
            'oficina_id.required' => __('El campo :attribute es necesario', ['attribute' => __('oficina')]),
            'oficina_id.exists' => __('El campo :attribute es invalido', ['attribute' => __('oficina')]),

            'categoria_id.required' => __('El campo :attribute es necesario', ['attribute' => __('categoria')]),
            'categoria_id.exists' => __('El campo :attribute es invalido', ['attribute' => __('categoria')]),

            'modelo.required' => __('el campo :attribute es necesario', ['attribute' => __('modelo')]),
            'modelo.max' => __('El campo :attribute no debe ser mayor a  :max caracteres', ['attribute' => __('modelo'), 'max' => 255]),

            'status_id.required' => __('The :attribute field is required', ['attribute' => __('status')]),
            'status_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('status')]),
        ];
    }
}
