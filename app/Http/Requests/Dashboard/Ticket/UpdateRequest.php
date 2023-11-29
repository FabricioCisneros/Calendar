<?php

namespace App\Http\Requests\Dashboard\Ticket;

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
            'modelo' => ['required', 'max:255'],
        ];
    }

    public function messages(){
        return[
            'modelo.required' => __('The :attribute field is required', ['attribute' => __('modelo')]),
            'modelo.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('modelo'), 'max' => 255]),
        ];
    }
}
