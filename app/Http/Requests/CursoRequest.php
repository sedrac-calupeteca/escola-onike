<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
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
            'nome' =>  ['required','string', 'max:255'],
            'descricao' => ['string', 'nullable', 'max:255'],
            'nivel' => ['required', 'string', 'regex:/[PRIMARIO|SECUNDARIO|TECNICO|MEDIO]/'],
            'num_classe' => ['required', 'string', 'regex:/[7,8,9,10,11,12,13]/'],
            'is_fechado' => []
        ];
    }
}
