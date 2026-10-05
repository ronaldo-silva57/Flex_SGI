<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMudancaGestaoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'empresa_id'                 => ['required', 'exists:empresas,id'],
            'solicitante_id'             => ['nullable', 'exists:users,id'],
            'responsavel_aprovacao_id'   => ['nullable', 'exists:users,id'],
            'processo_id'                => ['nullable', 'exists:processos,id'],

            'codigo'                     => ['required', 'string', 'max:50'],
            'titulo'                     => ['required', 'string', 'max:255'],
            'tipo'                       => ['required', 'in:Processo,Equipamento,Layout,Documento,Pessoas/Estrutura,Sistema/IT,Outros'],
            'descricao_mudanca'          => ['required', 'string'],
            'justificativa'              => ['required', 'string'],

            'impacto_qualidade'          => ['nullable', 'string'],
            'impacto_ambiental'          => ['nullable', 'string'],
            'impacto_sso'                => ['nullable', 'string'],
            'impacto_seguranca_informacao'=> ['nullable', 'string'],

            'data_prevista'              => ['required', 'date'],
            'data_implementacao'         => ['nullable', 'date', 'after_or_equal:data_prevista'],
            'status'                     => ['required', 'in:Proposta,Em analise,Aprovada,Rejeitada,Em implementação,Concluída,Cancelada'],
            'parecer_aprovacao'          => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'empresa_id' => \App\Models\Empresa::value('id'),
        ]);
    }
}