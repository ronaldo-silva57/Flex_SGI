<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIshikawaCausaRequest extends FormRequest
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
            'responsavel_validacao_id'  => ['sometimes', 'required', 'exists:users,id'],
            'categoria'                 => ['sometimes', 'required', 'string', 'max:40'],
            'descricao'                 => ['sometimes', 'required', 'string'],
            'evidencia'                 => ['sometimes', 'nullable', 'string'],
            'confirmada'                => ['sometimes', 'boolean'],
            'causa_raiz'                => ['sometimes', 'boolean'],
        ];
    }
}
