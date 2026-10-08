<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAspectoAmbientalRequest extends FormRequest
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
            'descricao'         => ['sometimes', 'string'],
            'tipo'              => ['sometimes', 'in:Emissao ar,Efluente,Resíduo,Ruído,Uso recurso,Outros'],
            'impacto_associado' => ['nullable', 'string'],
            'significancia'     => ['nullable', 'integer', 'min:1', 'max:5'],
            'controle_existente'=> ['nullable', 'string'],
            'programa_gestao'   => ['nullable', 'string'],
            'status'            => ['sometimes', 'in:ativo,inativo'],
        ];
    }

   public function messages()
    {
        return [
            'empresa_id.required' => 'A empresa é obrigatória.',
            'descricao.required'  => 'A descrição é obrigatória.',
            'tipo.required'       => 'O tipo é obrigatório.',
            'significancia.min'   => 'A significância deve ser no mínimo 1.',
            'significancia.max'   => 'A significância deve ser no máximo 5.',
            'status.required'     => 'O status é obrigatório.',
        ];
    }
}
