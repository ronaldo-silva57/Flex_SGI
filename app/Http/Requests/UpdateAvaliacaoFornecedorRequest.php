<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAvaliacaoFornecedorRequest extends FormRequest
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
            'empresa_id'            => ['sometimes', 'exists:empresas,id'],
            'fornecedor_id'         => ['sometimes', 'exists:fornecedores,id'],
            'avaliador_id'          => ['nullable', 'exists:users,id'],
            'periodo_referencia'    => ['sometimes', 'string', 'max:20'],
            'nota_qualidade'        => ['nullable', 'numeric', 'between:0,100'],
            'nota_prazo'            => ['nullable', 'numeric', 'between:0,100'],
            'nota_atendimento'      => ['nullable', 'numeric', 'between:0,100'],
            'nota_esg_ambiental'    => ['nullable', 'numeric', 'between:0,100'],
            'nota_final'            => ['nullable', 'numeric', 'between:0,100'],
            'status_qualificacao'   => ['sometimes', 'in:Aprovado,Aprovado com Restrição,Reprovado,Em observação'],
            'observacoes'           => ['nullable', 'string'],
            'plano_acao_exigido'    => ['nullable', 'string'],
        ];
    }
}
