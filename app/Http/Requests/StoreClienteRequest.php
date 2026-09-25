<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $empresaId = auth()->user()->empresa_id ?? $this->input('empresa_id');

        return [
            'empresa_id' => ['required', 'exists:empresas,id'],
            'tipo_documento' => ['nullable', 'in:cpf,cnpj'],
            'documento' => [
                'nullable', 
                'string', 
                'max:20',
                // Regra composta da nossa migration: único por empresa_id
                Rule::unique('clientes')->where(function ($query) use ($empresaId) {
                    return $query->where('empresa_id', $empresaId)
                                 ->where('tipo_documento', $this->input('tipo_documento'));
                })
            ],
            'nome'                      => ['required', 'string', 'max:255'],
            'razao_social'              => ['nullable', 'string', 'max:255'],
            'contato_principal'         => ['nullable', 'string', 'max:255'],
            'email'                     => ['nullable', 'email', 'max:255'],
            'telefone'                  => ['nullable', 'string', 'max:25'],
            'cidade'                    => ['nullable', 'string', 'max:100'],
            'estado'                    => ['nullable', 'string', 'size:2'],
            'endereco_completo'         => ['nullable', 'string'],
            'status'                    => ['required', 'in:ativo,inativo,bloqueado_sgi'],
            'observacoes_compliance'    => ['nullable', 'string'],
        ];
    }
}
