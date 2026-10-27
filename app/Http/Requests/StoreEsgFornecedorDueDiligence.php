<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEsgFornecedorDueDiligence extends FormRequest
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
            'empresa_id' => ['required', 'exists:empresas,id'],
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'stakeholders' => ['nullable', 'exists:stakeholders,id'],
            'nome_fornecedor' => ['required', 'string'],
            'cnpj_fornecedor' => ['nullable', 'string'],
            'nivel_risco' => []
        ];
    }
}
