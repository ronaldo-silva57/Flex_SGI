<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNaoConformidadeAmbientalRequest extends FormRequest
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
            'codigo'                    => ['sometimes','string','max:40'],
            'titulo'                    => ['sometimes','string','max:255'],
            'origem'                    => ['sometimes','in:Auditoria,Fiscalização,Monitoramento,Reclamação,Incidente,Outros'],
            'local_ocorrencia'          => ['nullable','string','max:255'],
            'descricao'                 => ['sometimes','string'],
            'requisito_nao_atendido'    => ['nullable','string'],
            'evidencia_inicial'         => ['nullable','string'],
            'gravidade'                 => ['nullable','in:Baixa,Média,Alta,Crítica'],
            'probabilidade'             => ['nullable','string','max:20'],
            'prioridade'                => ['nullable','string','max:20'],
            'recorrente'                => ['nullable','boolean'],
            'status'                    => ['sometimes','in:Aberta,Em análise,Em ação,Verificação,Fechada'],
            'data_identificacao'        => ['nullable','date'],
            'data_abertura'             => ['nullable','date'],
            'prazo_tratamento'          => ['nullable','date'],
            'data_analise'              => ['nullable','date'],
            'data_verificacao'          => ['nullable','date'],
            'data_encerramento'         => ['nullable','date'],
            'justificativa_encerramento'=> ['nullable','string'],
            'acao_corretiva'            => ['nullable','string'],
            'licenca_ambiental_id'      => ['nullable','exists:licencas_ambientais,id'],
            'aspecto_ambiental_id'      => ['nullable','exists:aspectos_ambientais,id'],
            'processo_id'               => ['nullable','exists:processos,id'],
            'responsavel_apuracao_id'   => ['nullable','exists:users,id'],
            'responsavel_tratamento_id' => ['nullable','exists:users,id'],
        ];
    }
}
