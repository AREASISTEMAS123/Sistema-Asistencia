<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'dni' => 'required|string|max:20|unique:dni',
            // 'profile' => 'required|string|max:191|confirmed',
            'cellphone' => 'required|string|max:11|unique:cellphone',
            'shift' => 'required|string|max:191',
            'birthday' => 'required|date|max:191',
            'image' => 'required|string|max:191',
            'date_start' => 'required|date|max:191',
            'date_end' => 'required|date|max:191',
            // 'cores_id' => 'required|int|max:5|confirmed'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string' => 'El nombre de usuario debe ser una cadena de texto.',
            'username.max' => 'El nombre de usuario no debe exceder los 191 caracteres.',

            'surname.required' => 'El apellido es obligatorio.',
            'surname.string' => 'El apellido debe ser una cadena de texto.',
            'surname.max' => 'El apellido no debe exceder los 191 caracteres.',

            'email.required' => 'El email es obligatorio.',
            'email.string' => 'El email debe ser una cadena de texto.',
            'email.email' => 'Debes introducir un email válido.',
            'email.max' => 'El email no debe exceder los 191 caracteres.',
            'email.unique' => 'Este email ya está en uso.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            'dni.required' => 'El DNI es obligatorio.',
            'dni.max' => 'El DNI no debe exceder los 20 caracteres.',
            'dni.unique' => 'Este DNI ya está registrado.',

            'cellphone.required' => 'El número de teléfono es obligatorio.',
            'cellphone.max' => 'El número de teléfono no debe exceder los 11 caracteres.',
            'cellphone.unique' => 'Este número de teléfono ya está registrado.',

            'shift.required' => 'El turno es obligatorio.',
            'shift.max' => 'El turno no debe exceder los 191 caracteres.',

            'birthday.required' => 'La fecha de nacimiento es obligatoria.',
            'birthday.date' => 'Debes introducir una fecha de nacimiento válida.',
            'birthday.max' => 'La fecha de nacimiento no debe exceder los 191 caracteres.',

            'image.required' => 'La imagen es obligatoria.',
            'image.max' => 'La imagen no debe exceder los 191 caracteres.',

            'date_start.required' => 'La fecha de inicio es obligatoria.',
            'date_start.date' => 'Debes introducir una fecha de inicio válida.',
            'date_start.max' => 'La fecha de inicio no debe exceder los 191 caracteres.',

            'date_end.required' => 'La fecha de finalización es obligatoria.',
            'date_end.date' => 'Debes introducir una fecha de finalización válida.',
            'date_end.max' => 'La fecha de finalización no debe exceder los 191 caracteres.',
        ];
    }
}
