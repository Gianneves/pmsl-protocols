<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelLegends\PtBrValidator\Rules\FormatoCpf;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile' => 'required|string|size:1|in:T,S,A',
            'cpf' =>  ['required', new FormatoCpf],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório!',
            'cpf' => 'CPF inválido!',
            'confirmed' => 'Senhas devem ser iguais!'
        ];
    }
}
