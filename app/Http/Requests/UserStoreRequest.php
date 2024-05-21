<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\CPFValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserStoreRequest extends FormRequest

{

    public function authorize(): bool 

    {
        return true;
    }


    public function rules(): array

    {

        $userId = $this->route('user');
        $cpf = $this->input('cpf') ? preg_replace('/\D/', '', $this->input('cpf')) : null;

        $rules = [
            'name' => 'required|min:3|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|min:3'
        ];
    
        if ($this->isMethod('PUT')) {
            $rules['cpf'] = 'sometimes';
        } else {
            $rules['cpf'] = [
                'required',
                new CPFValidation,
                Rule::unique('people', 'cpf')->ignore($userId)->where(function ($query) use ($cpf) {
                    return $query->where('cpf', $cpf);
                }),
            ];
        }
    
        return $rules;

    }


    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório!',
            'cpf' => 'CPF inválido!',
            'cpf.unique' => 'CPF já cadastrado.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->cpf) {
            $this->merge([
                'cpf' => preg_replace('/\D/', '', $this->cpf),
            ]);
        }
    }
}