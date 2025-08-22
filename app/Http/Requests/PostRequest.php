<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required_without:image|string|max:500|nullable',
            'image' => 'nullable|image|max:2048',
            'is_public' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'content.required_without' => 'Post content or image is required',
            'image.image' => 'The file must be an image',
            'image.max' => 'The image may not be greater than 2MB'
        ];
    }
}