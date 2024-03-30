<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|unique:users|string|min:6',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string|min:6',
        ];
    }
}