<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRiscoOportunidadeRequest extends FormRequest
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
            'empresa_id'     => ['sometimes', 'required', 'integer', Rule::exists('empresas', 'id')],
            'processo_id'    => ['nullable', 'integer', Rule::exists('processos', 'id')],
            'responsavel_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'tipo'           => ['sometimes', 'required', Rule::in(['Risco', 'Oportunidade'])],
            'descricao'      => ['sometimes', 'required', 'string'],
            'causa'          => ['nullable', 'string'],
            'consequencia'   => ['nullable', 'string'],
            'probabilidade'  => ['nullable', 'integer', 'between:1,5'],
            'impacto'        => ['nullable', 'integer', 'between:1,5'],
            'tratamento'     => ['nullable', Rule::in(['Eliminar', 'Mitigar', 'Transferir', 'Aceitar'])],
            'plano_acao'     => ['nullable', 'string'],
            'prazo'          => ['nullable', 'date'],
            'status'         => ['sometimes', 'required', Rule::in(['Aberto', 'Em andamento', 'Concluído', 'Cancelado'])],
            'evidencia'      => ['nullable', 'string'],
        ];
    }
}
