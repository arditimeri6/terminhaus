<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeFilterRequest extends FormRequest
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
            'filter_by' => 'required|in:1,2,3',
        ];
    }

    public function messages()
    {
        return[

        ];
    }
}
