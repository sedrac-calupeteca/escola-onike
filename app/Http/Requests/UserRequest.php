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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $perms = $this->rulesNotCredencials();
        $perms['password'] = ['required', 'string', 'min:8', 'confirmed'];
        $perms['confirm_password'] = ['string', 'min:8'];
        return $perms;
    }

    public function rulesNotCredencials(){
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'data_nascimento' => ['required', 'date'],
            'bilhete_identidade' => ['required', 'string', 'regex:/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z][A-Z][0-9][0-9][0-9]/', 'unique:users']
        ];
    }

}
