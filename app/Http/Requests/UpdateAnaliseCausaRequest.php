<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnaliseCausaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nao_conformidade_id' => ['sometimes', 'required', 'exists:nao_conformidades,id'],
            'responsavel_id'      => ['sometimes', 'nullable', 'exists:users,id'],
            'metodo'              => ['sometimes', 'required', 'string', 'max:40'],
            'status'              => ['sometimes', 'nullable', 'string', 'max:30'],
            'objetivo'            => ['sometimes', 'nullable', 'string'],
            'conclusao'           => ['sometimes', 'nullable', 'string'],
            'data_inicio'         => ['sometimes', 'nullable', 'date'],
            'data_conclusao'      => ['sometimes', 'nullable', 'date'],
        ];
    }
}
