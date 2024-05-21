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
            'departament_id' => 'required',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3072',
            'files' => 'nullable|array|max:5'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $totalSize = 0;
            if ($this->has('files')) {
                foreach ($this->file('files') as $file) {
                    $totalSize += $file->getSize();
                }
            }
            $maxSize = 3 * 1024 * 1024; 
            if ($totalSize > $maxSize) {
                $validator->errors()->add('files', 'O tamanho total dos arquivos não pode exceder 3MB.');
            }
        });
    }

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório',
            'between' => 'O prazo deve ser entre 5 e 30 dias.',
            'numeric' => 'O prazo deve ser um valor numérico.',
            'person_id.exists' => 'O contribuinte deve ter pelo menos 16 anos de idade.',
            'files.*.mimes' => 'Apenas arquivos do tipo JPG, JPEG, PNG e PDF são permitidos.',
            'files.*.max' => 'Cada arquivo não pode exceder 3MB.',
            'files.max' => 'Você pode fazer upload de no máximo 5 arquivos.',
            'files.total' => 'O tamanho total dos arquivos não pode exceder 3MB.'
        ];
    }
}
