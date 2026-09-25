<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnaliseIshikawaRequest extends FormRequest
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
            'analise_causa_id'  => ['required', 'exists:analises_causa,id'],
            'responsavel_id'    => ['required', 'exists:users,id'],
            'efeito_analisado'  => ['required', 'string', 'max:255'],
            'conclusao'         => ['nullable', 'string'],
            'data_inicio'       => ['nullable', 'date'],
            'data_conclusao'    => ['nullable', 'date'],
        ];
    }
}
