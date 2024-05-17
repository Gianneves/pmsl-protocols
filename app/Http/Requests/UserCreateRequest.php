<?php

namespace App\Http\Requests;

use App\Rules\CPFValidation;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


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
        $userId = $this->route('user');

        $rules = [
            'name' => 'required|min:3|max:255',
            'profile' => 'required|string|size:1|in:T,S,A'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['cpf'] = 'sometimes';
            $rules['email'] = 'sometimes|email|max:255';
        } else {
            $rules['cpf'] = [
                'required',
                new CPFValidation,
                Rule::unique('people', 'cpf')->ignore($userId),
            ];
            $rules['email'] = [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ];
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório!',
            'cpf' => 'CPF inválido!',
            'confirmed' => 'Senhas devem ser iguais!',
            'cpf.unique' => 'CPF já cadastrado.',
            'email.unique' => 'Email já cadastrado.',
        ];
    }
}
