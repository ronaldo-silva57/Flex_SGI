<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProcessoRequest extends FormRequest
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
            'empresa_id'       => ['nullable', 'exists:empresas,id'],
            'departamento_id'  => ['nullable', 'exists:departamentos,id'],
            'responsavel_id'   => ['nullable', 'exists:users,id'],
            'codigo'           => ['nullable', 'string', 'max:50',
                                    Rule::unique('processos', 'codigo')->ignore($this->route('processo'))
                                ],
            'nome'             => ['nullable', 'string', 'max:255'],
            'descricao'        => ['nullable', 'string'],
            'objetivo'         => ['nullable', 'string'],
            'entradas'         => ['nullable', 'string'],
            'saidas'           => ['nullable', 'string'],
            'indicadores_chave'=> ['nullable', 'string'],
            'tipo'             => ['nullable', 'in:Estratégico,Principal,Apoio'],
            'ativo'            => ['nullable', 'boolean'],
        ];
    }
}
