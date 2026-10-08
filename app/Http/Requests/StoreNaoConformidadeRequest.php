<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNaoConformidadeRequest extends FormRequest
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
            'empresa_id'                    => ['required', 'exists:empresas,id'],
            'cliente_id'                    => ['nullable', 'exists:clientes,id'],
            'norma_id'                      => ['nullable', 'exists:normas,id'],
            'clausula_id'                   => ['nullable', 'exists:clausulas,id'],
            'processo_id'                   => ['nullable', 'exists:processos,id'],
            'responsavel_apuracao_id'       => ['nullable', 'exists:users,id'],
            'responsavel_tratamento_id'     => ['required', 'exists:users,id'],
            'codigo'                        => ['required', 'string','max:40',
                                            Rule::unique('nao_conformidades', 'codigo')
                                                ->where(function ($query) {
                                                    return $query->where(
                                                        'empresa_id',
                                                        $this->empresa_id
                                                    );
                                                })
                                            ],
            'titulo'                        => ['required', 'string','max:255'],
            'tipo'                          => ['nullable', 'string','max:40'],
            'origem'                        => ['required', 'in:Auditoria,Monitoramento,Reclamacao,Incidente,Outros'],
            'local_ocorrencia'              => ['nullable', 'string','max:255'],
            'descricao'                     => ['required', 'string'],
            'requisito_nao_atendido'        => ['nullable', 'string'],
            'evidencia_inicial'             => ['nullable', 'string'],
            'gravidade'                     => ['nullable', 'in:Baixa,Media,Alta,Crítica'],
            'probabilidade'                 => ['nullable', 'string','max:20'],
            'prioridade'                    => ['nullable', 'string','max:20'],
            'recorrente'                    => ['boolean'],
            'status'                        => ['nullable', 'in:Aberta,Em analise,Em ação,Verificação,Fechada'],
            'data_identificacao'            => ['nullable', 'date'],
            'data_abertura'                 => ['nullable', 'date'],
            'prazo_tratamento'              => ['nullable', 'date'],
            'data_analise'                  => ['nullable', 'date'],
            'data_verificacao'              => ['nullable', 'date'],
            'data_encerramento'             => ['nullable', 'date'],
            'justificativa_encerramento'    => ['nullable', 'string'],
        ];
    }
}