<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreProcessoRequest extends FormRequest
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
            'empresa_id'        => ['nullable', 'exists:empresas,id'],
            'departamento_id'   => ['nullable', 'exists:departamentos,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'codigo'            => ['required', 'string', 'max:50'],
            'nome'              => ['required', 'string', 'max:255'],
            'descricao'         => ['nullable', 'string'],
            'objetivo'          => ['nullable', 'string'],
            'entradas'          => ['nullable', 'string'],
            'saidas'            => ['nullable', 'string'],
            'indicadores_chave' => ['nullable', 'string'],
            'tipo'              => ['nullable', 'in:Estratégico,Principal,Apoio'],
            'ativo'             => ['nullable', 'boolean'],
        ];
    }

    #[Override]
    protected function prepareForValidation()
    {
        if (empty($this->empresa_id)){
            $this->merge([
                'empresa_id' => auth()->user()->empresa_id ?? null,
            ]);
        }

        if (empty($this->responsavel_id)){
            $this->merge([
                'responsavel_id' => auth()->id(),
            ]);
        }
    }
}
