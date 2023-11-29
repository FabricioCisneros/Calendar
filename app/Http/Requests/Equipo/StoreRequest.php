<?php

namespace App\Http\Requests\Equipo;

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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => ['required', 'max:255'],
            'department_id' => ['exclude_if:department_id,null', 'exists:departments,id'],
            'status'=>['required']
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => __('The :attribute field is required', ['attribute' => __('subject')]),
            'subject.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('subject'), 'max' => 255]),
            'department_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('department')]),
            'status.required'=>__('The :attribute field is required', ['attribute' => __('status')])
        ];
    }
}
