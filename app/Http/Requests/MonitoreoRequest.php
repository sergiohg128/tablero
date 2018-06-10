<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonitoreoRequest extends FormRequest
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
			'descripcion' 			=> 'required|max:150',
			'fecha' 				=> 'required|date_format:Y-m-d|before_or_equal:today',
			'observacion' 			=> 'required|max:300',
			'meta_id' 				=> 'required|integer|exists:metas,id',
        ];
    }
}
