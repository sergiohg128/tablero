<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nombres'=>'required|string',
            'paterno'=>'required',
            'materno'=>'required',
            'cuenta' => 'required|string|max:50|unique:usuario',
            'password'=>'required',
            'oficina_id' => 'required',
        ];
    }

    public function messages(){
      return[
        'nombres.required' => 'Nombres requerido',
        'paterno.required' => 'Apellido paterno requerido',
        'materno.required' => 'Apellido materno requerido',
        'cuenta.required' => 'Cuenta requerida',
        'cuenta.unique' => 'La cuenta ya existe',
        'password.required' => 'Contraseña requrida',
        'oficina_id.required' => 'Seleccione una oficina'
      ];
    }
}
