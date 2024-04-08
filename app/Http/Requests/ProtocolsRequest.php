<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'description' => 'required|min:3|max:2000',
            'created_data' => 'required|date',
            'deadline' => 'required|numeric',
            'person_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório',
        ];
    }
}
