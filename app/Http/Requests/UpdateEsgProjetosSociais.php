<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEsgProjetosSociais extends FormRequest
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
            'responsavel_id'        => ['nullable', 'exists:users,id'],
            'nome_projeto'          => ['sometimes', 'string'],
            'descricao'             => ['nullable', 'string'],
            'localidade'            => ['nullable', 'string', 'max:150'],
            'data_inicio'           => ['date'],
            'data_fim'              => ['date'],
            'orcamento_investido'   => ['nullable', 'numeric', 'min:0'],
            'beneficiarios_diretos' => ['integer', 'min:0'],
            'status'                => ['nullable', 'in:Planejado,Em Andamento,Concluído, Cancelado'],
        ];
    }
}
