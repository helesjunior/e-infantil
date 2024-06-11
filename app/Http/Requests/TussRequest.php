<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TussRequest extends FormRequest
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
             'code' => 'required|min:8|max:8|unique:tuss,code,'.$id,
             'description' => 'required|min:5|max:255'
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
            'code.required' => 'O Campo "Código" é obrigatório!',
            'code.unique' => 'Esse "TUSS" já está cadastrado!',
            'code.min' => 'O campo "Código" deve ser no mínimo 8 caracteres!',
            'code.max' => 'O campo "Código" deve ser no máximo 8 caracteres!',
            'description.required' => 'O Campo "Descrição" é obrigatório!',
            'description.min' => 'O campo "Descrição" deve ser no mínimo 5 caracteres!',
            'description.max' => 'O campo "Descrição" deve ser no máximo 255 caracteres!',
        ];
    }
}
