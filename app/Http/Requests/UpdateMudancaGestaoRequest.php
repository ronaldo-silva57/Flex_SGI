<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMudancaGestaoRequest extends FormRequest
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
            'empresa_id'                    => ['sometimes', 'exists:empresas,id'],
            'solicitante_id'                => ['nullable', 'exists:users,id'],
            'responsavel_aprovacao_id'      => ['nullable', 'exists:users,id'],
            'processo_id'                   => ['nullable', 'exists:processos,id'],
            'codigo'                        => ['sometimes', 'string', 'max:50', 'unique:mudancas_gestao,codigo,' . $id],
            'titulo'                        => ['sometimes', 'string', 'max:255'],
            'tipo'                          => ['sometimes', 'in:Processo,Equipamento,Layout,Documento,Pessoas/Estrutura,Sistema/IT,Outros'],
            'descricao_mudanca'             => ['sometimes', 'string'],
            'justificativa'                 => ['sometimes', 'string'],
            'impacto_qualidade'             => ['nullable', 'string'],
            'impacto_ambiental'             => ['nullable', 'string'],
            'impacto_sso'                   => ['nullable', 'string'],
            'impacto_seguranca_informacao'  => ['nullable', 'string'],
            'data_prevista'                 => ['sometimes', 'date'],
            'data_implementacao'            => ['nullable', 'date'],
            'status'                        => ['sometimes', 'in:Proposta,Em analise,Aprovada,Rejeitada,Em implementação,Concluída,Cancelada'],
            'parecer_aprovacao'             => ['nullable', 'string'],
        ];
    }
}
