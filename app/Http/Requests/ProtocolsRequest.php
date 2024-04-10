<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProtocolsRequest extends FormRequest
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

        $minAge = Carbon::now()->subYears(16)->format('Y-m-d');

        return [
            'description' => 'required|min:3|max:2000',
            'created_data' => 'required|date',
            'deadline' => 'required|numeric|between:5,30',
            'person_id' => [
                'required',
                Rule::exists('people', 'id')->where(function ($query) use ($minAge) {
                    $query->where('birthdate', '<', $minAge);
                }),
            ],
            'files.*' => 'sometimes|file|mimes:jpg,jpeg,png,pdf|max:3000',
            'files' => 'max:5' 
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório',
            'between' => 'O prazo deve ser entre 5 e 30 dias.',
            'numeric' => 'O prazo deve ser um valor numérico.',
            'person_id.exists' => 'O contribuinte deve ter pelo menos 16 anos de idade.',
            'files.*.file' => 'O campo precisa ser um arquivo.',
            'files.*.mimes' => 'Os arquivos devem estar em formato JPG, JPEG, PNG ou PDF.',
            'files.*.max' => 'O tamanho máximo de arquivo permitido é 3MB.',
            'files.max' => 'Você só pode enviar no máximo 5 arquivos.'
        ];
    }
}
