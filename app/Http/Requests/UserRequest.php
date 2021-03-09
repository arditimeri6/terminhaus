<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'role_id' => 'required',
            'first_name' => 'required|string|max:20|regex:/[a-z]/|regex:/[A-Z]/',
            'last_name' => 'required|string|max:20|regex:/[a-z]/|regex:/[A-Z]/',
            'phone_number' => 'nullable|string|max:25',
            'username' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:191',
            'ip_address' => 'max:20',
            'password' => 'sometimes|nullable|string|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'password_confirmation' => 'sometimes|nullable|string|min:8'
        ];
    }
    public function messages()
    {
        return[
            'role_id.required' => 'Bitte wählen Sie eine Option',
        ];
    }
}
