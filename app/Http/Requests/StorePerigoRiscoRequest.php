<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePerigoRiscoRequest extends FormRequest
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
            'empresa_id'        => 'required|exists:empresas,id',
            'processo_id'       => 'nullable|exists:processos,id',
            'responsavel_id'    => 'nullable|exists:users,id',
            'descricao_perigo'  => 'required|string',
            'risco_associado'   => 'nullable|string',
            'exposicao'         => 'nullable|string',
            'probabilidade'     => 'nullable|integer|min:1|max:5',
            'severidade'        => 'nullable|integer|min:1|max:5',
            'medida_controle'   => 'nullable|string',
            'necessita_acao'    => 'boolean',
            'status'            => 'required|in:Ativo,Eliminado,Em tratamento',
        ];
    }

    public function messages()
    {
        return [
            'empresa_id.required'       => 'A empresa é obrigatória.',
            'descricao_perigo.required' => 'A descrição do perigo é obrigatória.',
            'probabilidade.min'         => 'A probabilidade deve ser no mínimo 1.',
            'probabilidade.max'         => 'A probabilidade deve ser no máximo 5.',
            'severidade.min'            => 'A severidade deve ser no mínimo 1.',
            'severidade.max'            => 'A severidade deve ser no máximo 5.',
            'status.required'           => 'O status é obrigatório.',
            'status.in'                 => 'Status inválido.',
        ];
    }
}
