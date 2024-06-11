<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
        $id = $this->get('id') ?? request()->route('id');

        return [
             'cpf_cnpj' => 'required|cpf_cnpj|unique:providers,cpf_cnpj,'.$id,
             'name' => 'required|min:5|max:255',
             'email' => 'required|email|unique:providers,email,'.$id,
             'address' => 'required|min:5|max:255',
             'zip_code' => 'required|min:9|max:9',
             'state_id' => 'required',
             'city_id' => 'required',
             'tuss' => 'required',
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
            'cpf_cnpj.required' => 'O Campo "CPF / CNPJ" é obrigatório!',
            'name.required' => 'O Campo "Nome Completo / Razão Social" é obrigatório!',
            'email.required' => 'O Campo "E-mail" é obrigatório!',
            'address.required' => 'O Campo "Endereço" é obrigatório!',
            'zip_code.required' => 'O Campo "CEP" é obrigatório!',
            'state_id.required' => 'O Campo "Estado" é obrigatório!',
            'city_id.required' => 'O Campo "Município" é obrigatório!',
            'tuss.required' => 'O Campo "TUSS" é obrigatório!',
            'name.min' => 'O campo "Nome Completo / Razão Social" deve ser no mínimo 5 caracteres!',
            'address.min' => 'O campo "Endereço" deve ser no mínimo 5 caracteres!',
            'zip_code.min' => 'O campo "CEP" deve ser no mínimo 9 caracteres!',
            'name.max' => 'O campo "Nome Completo / Razão Social" deve ser no máximo 255 caracteres!',
            'address.max' => 'O campo "Endereço" deve ser no máximo 255 caracteres!',
            'zip_code.max' => 'O campo "CEP" deve ser no máximo 9 caracteres!',
            'cpf_cnpj.unique' => 'Esse "CPF / CNPJ" já está cadastrado!',
            'email.unique' => 'Esse "E-mail" já está cadastrado!',
        ];
    }
}
