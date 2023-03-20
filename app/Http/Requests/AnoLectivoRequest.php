<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnoLectivoRequest extends FormRequest
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
            'codigo' => ['required', 'string', 'max:255','regex:/[2-9][0-9][0-9][0-9]\/[2-9][0-9][0-9][0-9]/i'],
            'data_inicio' => ['required', 'date'],
            'data_fim' => ['required', 'date'],
            'descricao' => ['string', 'nullable', 'max:255'],
            'is_terminado' => []       
        ];
    }

}
