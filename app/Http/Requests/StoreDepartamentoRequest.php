<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartamentoRequest extends FormRequest
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
            'empresa_id'     => ['required', 'exists:empresas,id'],
            'codigo' => ['required', 'string', 'max:50',
            Rule::unique('departamentos', 'codigo'),
        ],
            'nome'           => ['required', 'string', 'max:255'],
            'descricao'      => ['nullable', 'string'],
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'ativo'          => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'Já existe um departamento com este código.',
        ];
    }
}
