<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest

{


    public function rules(): array

    {


        return [
            'name' => 'required|min:3',
            'birthdate' => 'required|date',
            'cpf' => 'required|unique:people,cpf|min:3',
            'gender' => 'required|min:3'
        ];

    }


}