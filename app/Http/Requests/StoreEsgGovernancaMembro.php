<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreEsgGovernancaMembro extends FormRequest
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
            'empresa_id'        => ['required', 'exists:empresas,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'nome'              => ['required', 'string'],
            'orgao'             =>['required', 'in:Conselho de Administração,Diretoria Executiva,Comitê de Auditoria,Comitê ESG,Outro'],
            'cargo'             => ['required', 'string'],
            'independente'      => ['boolean'],
            'inicio_mandato'    => ['nullable', 'date'],
            'fim_mandato'       => ['nullable', 'date'],
            'ativo'             => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
        {
            $this->merge([
                'independente' => $this->boolean('independente'),
                'ativo'        => $this->boolean('ativo'),
            ]);
        }
}
