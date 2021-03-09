<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'new-password_confirmation' => 'required',
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|max:191|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
        ];
    }
    public function messages()
    {
        return[
            'new-password_confirmation.required' => 'Confirm password is required',
            'new-password.required' => 'New password is required',
            'current-password.required' => 'Current password is required',
            'new-password.confirmed' => 'asasa***',
            'new-password.regex' => 'aaa***',
            'new-password.max' => 'Das neue Kennwort darf nicht länger als 191 Zeichen sein.',
        ];
    }
}
