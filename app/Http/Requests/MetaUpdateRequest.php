<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaUpdateRequest extends FormRequest
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
			'fecha_inicio' 			=> 'sometimes|required|date_format:Y-m-d',
			'fecha_fin' 			=> 'sometimes|required|date_format:Y-m-d|after_or_equal:fecha_inicio',
			'producto' 				=> 'required|max:255',
			'presupuesto' 			=> 'required|numeric|min:0',
			'estado' 				=> 'required|in:P,E,F',
        ];
    }
}
