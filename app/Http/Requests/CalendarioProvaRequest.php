<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarioProvaRequest extends FormRequest
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
            'calendario_id' => ['required'],
            'prova_id' => ['required'],
            'data' => ['required','date'],
            'hora_comeco' => ['required'],
            'hora_fim' => ['required']
        ];
    }
}
