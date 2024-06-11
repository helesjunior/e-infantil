<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreCrudRequest extends FormRequest
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
            'cpf'    => 'required|cpf|unique:users,cpf',
            'email'    => 'required|email|max:255|unique:users,email',
            'name'     => 'required|max:255',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'cpf.required' => 'O campo "CPF" é obrigatório!',
            'cpf.cpf' => 'CPF inválido!',
            'cpf.unique' => 'Este CPF já está cadastrado!',
            'name.required' => 'O campo "Nome" é obrigatório!',
            'name.max' => 'O campo "Nome" deve ser no máximo 255 caracteres!',
            'email.unique' => 'Este E-mail já está cadastrado!',
            'email.email' => 'E-mail inválido!',
            'email.required' => 'O campo "E-mail" é obrigatório!',
            'email.max' => 'O campo "E-mail" deve ser no máximo 255 caracteres!',
            'password.confirmed' => 'O campo "Senha" precisa ser confirmado!',
        ];
    }

}
