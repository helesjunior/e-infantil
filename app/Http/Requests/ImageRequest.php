<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'filename' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'filename' => 'Image',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'filename.required' => 'O campo imagem é obrigatório.',
            'filename.image' => 'O arquivo deve ser uma imagem.',
            'filename.mimes' => 'A imagem deve ser um arquivo dos tipos: jpeg, png, jpg, gif.',
            'filename.max' => 'O tamanho da imagem não pode exceder 2MB.',
        ];
    }
}
