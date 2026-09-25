<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRiscoOportunidadeRequest extends FormRequest
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
            'empresa_id'     => ['required', 'integer', Rule::exists('empresas', 'id')],
            'processo_id'    => ['nullable', 'integer', Rule::exists('processos', 'id')],
            'responsavel_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'tipo'           => ['required', Rule::in(['Risco', 'Oportunidade'])],
            'descricao'      => ['required', 'string'],
            'causa'          => ['nullable', 'string'],
            'consequencia'   => ['nullable', 'string'],
            'probabilidade'  => ['nullable', 'integer', 'between:1,5'],
            'impacto'        => ['nullable', 'integer', 'between:1,5'],
            'tratamento'     => ['nullable', Rule::in(['Eliminar', 'Mitigar', 'Transferir', 'Aceitar'])],
            'plano_acao'     => ['nullable', 'string'],
            'prazo'          => ['nullable', 'date'],
            'status'         => ['nullable', Rule::in(['Aberto', 'Em andamento', 'Concluído', 'Cancelado'])],
            'evidencia'      => ['nullable', 'string'],
        ];
    }

/**
     * Mensagens de validação personalizadas.
     */
    public function messages(): array
    {
        return [
            'empresa_id.required'   => 'Por favor, selecione uma empresa válida.',
            'empresa_id.exists'     => 'A empresa selecionada não foi encontrada em nosso sistema.',
            'processo_id.exists'    => 'O processo selecionado é inválido.',
            'responsavel_id.exists' => 'O usuário responsável selecionado não existe.',
            'tipo.required'         => 'Informe se o registro é um Risco ou uma Oportunidade.',
            'tipo.in'               => 'O tipo deve ser "Risco" ou "Oportunidade".',
            'descricao.required'    => 'Preencha a descrição para detalhar o risco ou a oportunidade.',
            'probabilidade.between' => 'A probabilidade deve ser um valor entre 1 e 5.',
            'impacto.between'       => 'O impacto deve ser um valor entre 1 e 5.',
            'tratamento.in'         => 'Selecione uma opção válida para a estratégia de tratamento.',
            'prazo.date'            => 'Informe uma data válida para o prazo.',
            'status.in'             => 'O status selecionado não é válido.',
        ];
    }

    /**
     * Tradução dos nomes dos atributos.
     */
    public function attributes(): array
    {
        return [
            'empresa_id'     => 'empresa',
            'processo_id'    => 'processo',
            'responsavel_id' => 'responsável',
            'tipo'           => 'tipo',
            'descricao'      => 'descrição',
            'causa'          => 'causa',
            'consequencia'   => 'consequência',
            'probabilidade'  => 'probabilidade',
            'impacto'        => 'impacto',
            'tratamento'     => 'tratamento',
            'plano_acao'     => 'plano de ação',
            'prazo'          => 'prazo',
            'status'         => 'status',
            'evidencia'      => 'evidência',
        ];
    }
}
