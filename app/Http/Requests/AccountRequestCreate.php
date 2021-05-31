<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequestCreate extends FormRequest
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
            'cpf' => 'required|unique:users',
            'cnpj' => 'unique:shops',
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
            'cpf.required'   => 'O campo cpf é obrigatório',
            'cpf.unique'   => 'Ja existe um usuário com este número de cpf',
            'cnpj.unique'   => 'Ja existe uma loja com este número de cnpj',
            'email.required'   => 'O campo email é obrigatório',
            'email.email'   => 'O campo email deve conter um email valido',
            'email.unique'   => 'Já existe um usuário com este e-mail cadastrado',
            'password.required'   => 'O campo senha é obrigatório',
        ];
    }
}
