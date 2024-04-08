<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LaravelLegends\PtBrValidator\Rules\FormatoCpf;

class UserStoreRequest extends FormRequest

{

    public function authorize(): bool 

    {
        return true;
    }


    public function rules(): array

    {
        return [
            'name' => 'required|min:3|max:255',
            'birthdate' => 'required|date',
            'cpf' => ['required', new FormatoCpf],
            'gender' => 'required|min:3'
        ];

    }


    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório!',
            'cpf' => 'CPF inválido!'
        ];
    }


}