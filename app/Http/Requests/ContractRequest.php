<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'number' => 'required|min:9|max:9|not_in:____/____',
             'provider_id' => 'required',
             'signature_date' => 'required',
             'beginning_date_term' => 'required',
             'end_date_term' => 'required',
             'object' => 'required',
             'items' => 'required',
             'items.*.tuss' => 'required',
             'items.*.price' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'number.required' => 'O Campo "Número contrato" é obrigatório!',
            'number.min' => 'O campo "Número contrato" deve ser no mínimo 200 caracteres!',
            'number.max' => 'O campo "Número contrato" deve ser no máximo 9 caracteres!',
            'number.not_in' => 'O Campo "Número contrato" precisa ser válido!',
            'provider_id.required' => 'O Campo "Prestador principal" é obrigatório!',
            'signature_date.required' => 'O Campo "Data assinatura" é obrigatório!',
            'beginning_date_term.required' => 'O Campo "Data vigência início" é obrigatório!',
            'end_date_term.required' => 'O Campo "Data vigência fim" é obrigatório!',
            'object.required' => 'O Campo "Objeto" é obrigatório!',
            'items.required' => 'O Campo "Itens do contratos" é obrigatório!',
            'items.*.tuss.required' => 'O Campo "Itens do contratos / TUSS"  é obrigatório!',
            'items.*.price.required' => 'O Campo "Itens do contratos / Valor" é obrigatório!',
        ];
    }
}
