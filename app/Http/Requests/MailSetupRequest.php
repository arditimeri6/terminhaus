<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailSetupRequest extends FormRequest
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
            'username' => 'required|max:255',
            'password' => 'required|string|min:6',
            'host' => 'required',
            'port' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
        ];
    }
}
