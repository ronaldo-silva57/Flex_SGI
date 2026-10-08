<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePerigoRiscoRequest extends FormRequest
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
            'empresa_id'        => ['sometimes', 'exists:empresas,id'],
            'processo_id'       => ['nullable', 'exists:processos,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'descricao_perigo'  => ['sometimes', 'string'],
            'risco_associado'   => ['nullable', 'string'],
            'exposicao'         => ['nullable', 'string'],
            'probabilidade'     => ['nullable', 'integer', 'min:1', 'max:5'],
            'severidade'        => ['nullable', 'integer', 'min:1', 'max:5'],
            'medida_controle'   => ['nullable', 'string'],
            'necessita_acao'    => ['boolean'],
            'status'            => ['sometimes', 'in:Ativo,Eliminado,Em tratamento'],
        ];
    }
}
