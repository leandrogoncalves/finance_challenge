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
            'fullname' => 'required',
            'type'  => 'required',
            'document' => 'required',
            'email' => 'required|email',
            'password'  => 'required',
        ];
    }

    /**
     * Get messages from errors
     *
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'fullname.required'   => 'O campo nome completo é obrigatório',
            'type.required'   => 'O campo tipo é obrigatório',
            'document.required'   => 'O campo documento é obrigatório',
            'email.required'   => 'O campo email é obrigatório',
            'email.email'   => 'O campo email deve conter um email valido',
            'password.required'   => 'O campo senha é obrigatório',
        ];
    }
}
