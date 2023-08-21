<?php

namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest{

    public function rules(): array{
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }
    public function messages(): array{
        return [
            'username.required' => ['Por favor ingrese el usuario '],
            'password.required' => ['Por favor ingrese la contraseña']
        ];
    }
}
