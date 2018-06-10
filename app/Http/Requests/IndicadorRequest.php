<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicadorRequest extends FormRequest
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
            'nombre' => 'required',
            'anio' => 'required|numeric|min:1900',
            'oficina_id' => 'required',
        ];
    }

    public function messages(){
      return [
        'nombre.required'=>'Nombre requerido',
        'anio.required'=>'Año requerido',
        'anio.numeric'=>'Ingrese un número',
        'anio.min'=>'Ingrese un año correcto',
        'oficina_id' => 'Selecione una oficina',
      ];
    }
}
