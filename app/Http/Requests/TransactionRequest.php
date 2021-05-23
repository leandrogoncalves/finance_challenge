<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'payer' => 'required',
            'payee' => 'required',
            'value' => 'required',
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
            'payer.required'   => 'O id da conta de origem é obrigatório',
            'payee.required'   => 'O id da conta de destino é obrigatório',
            'value.required'   => 'O valor é obrigatório',
        ];
    }
}
