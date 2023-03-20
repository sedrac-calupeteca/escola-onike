<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvaRequest extends FormRequest
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
            'professor_turma_id' =>  ['required','string', 'max:255'],
            'simestre' => ['required','string','regex:/[1|2|3]/i'],
            'tipo' => ['required','string','regex:/[EPOCA_1|EPOCA_2|EXAME|RECURSO]/i'],
        ];
    }
}
