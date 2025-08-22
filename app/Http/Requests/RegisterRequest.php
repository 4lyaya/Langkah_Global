<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'birthdate' => 'required|date|before:today',
            'profile_photo' => 'nullable|image|max:2048',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Full name is required',
            'username.required' => 'Username is required',
            'username.unique' => 'This username is already taken',
            'username.alpha_dash' => 'Username can only contain letters, numbers, dashes and underscores',
            'email.required' => 'Email address is required',
            'email.unique' => 'This email is already registered',
            'birthdate.required' => 'Date of birth is required',
            'birthdate.before' => 'Date of birth must be in the past',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'terms.accepted' => 'You must accept the terms and conditions'
        ];
    }
}