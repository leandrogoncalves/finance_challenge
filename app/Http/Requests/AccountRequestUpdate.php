<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequestUpdate extends FormRequest
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
            'cpf' => 'unique:users',
            'cnpj' => 'unique:shops',
            'email' => 'email|unique:users',
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
            'cpf.unique'   => 'Ja existe um usuário com este número de cpf',
            'cnpj.unique'   => 'Ja existe uma loja com este número de cnpj',
            'email.unique'   => 'Já existe um usuário com este e-mail cadastrado',
        ];
    }
}
