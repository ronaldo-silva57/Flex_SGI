<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnaliseIshikawaRequest extends FormRequest
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
            'analise_causa_id'  => ['sometimes', 'required', 'exists:analises_causa,id'],
            'responsavel_id'    => ['sometimes', 'required', 'exists:users,id'],
            'efeito_analisado'  => ['sometimes', 'required', 'string', 'max:255'],
            'conclusao'         => ['sometimes', 'nullable', 'string'],
            'data_inicio'       => ['sometimes', 'nullable', 'date'],
            'data_conclusao'    => ['sometimes', 'nullable', 'date'],
        ];
    }
}
