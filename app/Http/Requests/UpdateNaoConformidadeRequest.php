<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNaoConformidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtém a instância da modelo ou o ID passado pela rota
        $nc = $this->route('naoConformidade') ?? $this->route('nao_conformidade');
        $ncId = $nc instanceof Model ? $nc->getKey() : $nc;

        // Recupera o ID da empresa vindo da requisição ou direto do registro existente
        $empresaId = $this->input('empresa_id') ?? ($nc instanceof Model ? $nc->empresa_id : null);

        return [
            'empresa_id'                => ['sometimes', 'required', 'exists:empresas,id'],
            'cliente_id'                => ['sometimes', 'nullable', 'exists:clientes,id'],
            'norma_id'                  => ['sometimes', 'nullable', 'exists:normas,id'],
            'clausula_id'               => ['sometimes', 'nullable', 'exists:clausulas,id'],
            'processo_id'               => ['sometimes', 'nullable', 'exists:processos,id'],
            'responsavel_apuracao_id'   => ['sometimes', 'nullable', 'exists:users,id'],
            'responsavel_tratamento_id' => ['sometimes', 'required', 'exists:users,id'],

            'codigo' => [
                'sometimes',
                'required',
                'string',
                'max:40',
                Rule::unique('nao_conformidades', 'codigo')
                    ->where(fn ($query) => $query->where('empresa_id', $empresaId))
                    ->ignore($ncId),
            ],

            'titulo'                     => ['sometimes', 'required', 'string', 'max:255'],
            'tipo'                       => ['sometimes', 'nullable', 'string', 'max:40'],
            'origem'                     => ['sometimes', 'required', 'in:Auditoria,Monitoramento,Reclamacao,Incidente,Outros'],
            'local_ocorrencia'           => ['sometimes', 'nullable', 'string', 'max:255'],
            'descricao'                  => ['sometimes', 'required', 'string'],
            'requisito_nao_atendido'     => ['sometimes', 'nullable', 'string'],
            'evidencia_inicial'          => ['sometimes', 'nullable', 'string'],
            'gravidade'                  => ['sometimes', 'nullable', 'in:Baixa,Media,Alta,Crítica'],
            'probabilidade'              => ['sometimes', 'nullable', 'string', 'max:20'],
            'prioridade'                 => ['sometimes', 'nullable', 'string', 'max:20'],
            'recorrente'                 => ['sometimes', 'boolean'],
            'status'                     => ['sometimes', 'nullable', 'in:Aberta,Em analise,Em ação,Verificação,Fechada'],
            'data_identificacao'         => ['sometimes', 'nullable', 'date'],
            'data_abertura'              => ['sometimes', 'nullable', 'date'],
            'prazo_tratamento'           => ['sometimes', 'nullable', 'date'],
            'data_analise'               => ['sometimes', 'nullable', 'date'],
            'data_verificacao'           => ['sometimes', 'nullable', 'date'],
            'data_encerramento'          => ['sometimes', 'nullable', 'date'],
            'justificativa_encerramento' => ['sometimes', 'nullable', 'string'],
        ];
    }
}