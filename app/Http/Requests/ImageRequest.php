<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'title' => 'required|string|max:255', // Title is required and should be a string with a max length of 255 characters
            'filename' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File is optional, should be an image, and must be one of the specified mime types
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
            'title' => 'Title',
            'filename' => 'Image',
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
            'title.required' => 'The title field is required.',
            'filename.image' => 'The file must be an image.',
            'filename.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'filename.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
