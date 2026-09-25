<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAuditoriaItemRequest extends FormRequest
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
            'auditoria_id'          => ['required', 'exists:auditorias,id'],
            'clausula_id'           => ['nullable', 'exists:clausulas,id'],
            'processo_id'           => ['nullable', 'exists:processos,id'],
            'auditor_id'            => ['nullable', 'exists:users,id'],
            'descricao_verificacao' => ['required', 'string'],
            'evidencia_coletada'    => ['nullable', 'string'],
            'conformidade'          => ['nullable', Rule::in(['conforme', 'nao_conforme', 'oportunidade_melhoria', 'nao_aplicavel'])],
            'observacoes'           => ['nullable', 'string'],
        ];
    }
}
