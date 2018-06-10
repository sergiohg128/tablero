<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActividadRequest extends FormRequest
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
            'presupuesto' => 'nullable|numeric|min:0',
            'fecha_inicio' => 'required|date|',
            'fecha_fin_esperada'=>'required|date|after:fecha_inicio',
            'monitor_id' => 'required',
        ];
    }

    public function messages(){
      return [
        'nombre.required'=>'Nombre requerido',
        'presupuesto.numeric' => 'El campo presupuesto solo admite cantidades numericas',
        'presupuesto.min'=>'El campo presupuesto no admite cantidades negativas',
        'fecha_inicio.required'=>'Fecha inicial requerida',
        'fecha_fin_esperada.required'=>'Fecha final esperada requerida',
        'fecha_fin_esperada.after'=>'La fecha final esperada debe ser posterior a la fecha de inicio',
        'monitor_id' => 'Selecione un monitor',
      ];
    }
}
