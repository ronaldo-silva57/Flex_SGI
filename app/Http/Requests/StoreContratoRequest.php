<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreContratoRequest extends FormRequest
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
            'empresa_id'             => ['nullable', 'exists:empresas,id'],
            'cliente_id'             => ['nullable', 'exists:clientes,id'],
            'fornecedor_id'          => ['nullable', 'exists:fornecedores,id'],
            'responsavel_id'         => ['nullable', 'exists:users,id'],
            'numero_contrato'        => ['required', 'string', 'max:50'],
            'titulo'                 => ['required', 'string', 'max:255'],
            'tipo'                   => ['nullable', 'in:Cliente,Fornecedor,Parceria,Prestação de Serviço'],
            'valor_total'            => ['nullable', 'numeric', 'min:0'],
            'data_inicio'            => ['required', 'date'],
            'data_fim'               => ['required', 'date', 'after_or_equal:data_inicio'],
            'alerta_vencimento_dias' => ['nullable', 'integer', 'min:1'],
            'status'                 => ['nullable', 'in:Minuta,Vigente,Suspenso,Encerrado,Rescindido'],
            'objeto'                 => ['nullable', 'string'],
            'observacoes'            => ['nullable', 'string'],
            'arquivo_path'           => ['nullable', 'string'],
        ];
    }

    #[Override]
    protected function prepareForValidation()
    {
        if (empty($this->empresa_id)) {
            $this->merge([
                'empresa_id' => auth()->user()->empresa_id ?? null,
            ]);
        }

        if (empty($this->responsavel_id)) {
            $this->merge([
                'responsavel_id' => auth()->id(),
            ]);
        }
    }
}
