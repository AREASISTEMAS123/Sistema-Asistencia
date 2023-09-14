<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username' => 'string|max:191',
            'name' => 'string|max:191',
            'surname' => 'string|max:191',
            'email' => 'string|email|max:191',
            'password' => 'string|min:8',
            'status' => 'bool',
            'status_description'=>'',
            'dni' => 'string|max:20',
            'position_id' => 'int|max:191',
            'cellphone' => 'string|max:11',
            'shift' => 'string|max:191',
            'birthday' => 'date|max:191',
            'image' => '',
            'date_start' => 'date|max:191',
            'date_end' => 'date|max:191',
            'role_id' =>'string'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 191 caracteres.',

            'surname.required' => 'El apellido es obligatorio.',
            'surname.string' => 'El apellido debe ser una cadena de texto.',
            'surname.max' => 'El apellido no debe exceder los 191 caracteres.',

            'email.required' => 'El email es obligatorio.',
            'email.string' => 'El email debe ser una cadena de texto.',
            'email.email' => 'Debes introducir un email válido.',
            'email.max' => 'El email no debe exceder los 191 caracteres.',
            'email.unique' => 'Este email ya está en uso.',

            'position_id.required' =>'La posicion es requerida',

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
