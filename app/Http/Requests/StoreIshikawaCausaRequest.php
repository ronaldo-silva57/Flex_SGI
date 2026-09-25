<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreIshikawaCausaRequest extends FormRequest
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
            'analise_ishikawa_id'       => ['required', 'exists:analises_ishikawa,id'],
            'responsavel_validacao_id'  => ['required', 'exists:users,id'],
            'categoria'                 => ['required', 'string', 'max:40'],
            'descricao'                 => ['required', 'string'],
            'evidencia'                 => ['nullable', 'string'],
            'confirmada'                => ['boolean'],
            'causa_raiz'                => ['boolean'],
        ];
    }
}
