<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAcaoCorretivaRequest extends FormRequest
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
            'responsavel_id'      => ['nullable', 'exists:users,id'],
            'etapa'               => ['sometimes', 'required', Rule::in(['Contenção', 'Causa raiz', 'Correção', 'Verificação', 'Conclusão'])],
            'descricao'           => ['sometimes', 'required', 'string', 'max:5000'],
            'prazo'               => ['nullable', 'date'],
            'data_execucao'       => ['nullable', 'date'],
            'eficaz'              => ['nullable', 'boolean'],
            'evidencia'           => ['nullable', 'string'],
            'status'              => ['sometimes', Rule::in(['Pendente', 'Em andamento', 'Concluída', 'Reprovada'])],
        ];
    }
}
