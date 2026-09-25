<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStakeholderRequest extends FormRequest
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
            'empresa_id'   => ['required', 'exists:empresas,id'],
            'nome'         => ['required', 'string', 'max:255'],
            'tipo'         => ['required', Rule::in(['Cliente', 'Colaborador', 'Fornecedor', 'Comunidade', 'Investidor', 'Governo', 'Outros'])],
            'contato'      => ['nullable', 'string', 'max:255'],
            'expectativas' => ['nullable', 'string'],
            'necessidades' => ['nullable', 'string'],
            'prioridade'   => ['nullable', 'integer', 'between:1,5'],
            'ativo'        => ['nullable', 'boolean'],
        ];
    }
}
