<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'document' => 'required|unique:wallets',
            'email' => 'required|email|unique:users',
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
            'document.unique'   => 'Ja existe uma carteira com este número de documento',
            'email.required'   => 'O campo email é obrigatório',
            'email.email'   => 'O campo email deve conter um email valido',
            'email.unique'   => 'Já existe um usuário com este e-mail cadastrado',
            'password.required'   => 'O campo senha é obrigatório',
        ];
    }
}
