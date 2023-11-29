<?php

namespace App\Http\Requests\Dashboard\Admin\categoria;

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
            'name' => ['required', 'max:255'],
        ];
    }

    public function messages(){
        return[
        'name.required' => __('el campo :attribute es requerido', ['attribute' => __('name')]),
        'name.max' => __('el campo :attribute no debe ser mayor a :max caracteres', ['attribute' => __('name'), 'max' => 255])
        ];
    }
}
