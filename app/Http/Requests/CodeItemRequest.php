<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeItemRequest extends FormRequest
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
            'short_description' => 'max:50',
            'description' => 'required|max:200',
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
            'description.required' => 'O Campo "Descrição" é obrigatório!',
            'description.max' => 'O campo "Descrição" deve ser no máximo 200 caracteres!',
            'short_description.max' => 'O campo "Descrição" deve ser no máximo 50 caracteres!',
        ];
    }
}
