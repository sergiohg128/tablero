<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaStoreRequest extends FormRequest
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
			'nombre' 				=> 'required|max:255',
			'fecha_inicio_esperada' => 'required|date_format:Y-m-d',
			'fecha_fin_esperada' 	=> 'required|date_format:Y-m-d|after_or_equal:fecha_inicio_esperada',
			'producto' 				=> 'required|max:255',
			'presupuesto' 			=> 'required|numeric|min:0',
			'actividad_id' 			=> 'required|integer|exists:actividades,id',
        ];
    }
}
