<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContratoRequest extends FormRequest
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
            'numero_contrato'        => ['nullable', 'string', 'max:50'],
            'titulo'                 => ['nullable', 'string', 'max:255'],
            'tipo'                   => ['nullable', 'in:Cliente,Fornecedor,Parceria,Prestação de Serviço'],
            'valor_total'            => ['nullable', 'numeric', 'min:0'],
            'data_inicio'            => ['nullable', 'date'],
            'data_fim'               => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'alerta_vencimento_dias' => ['nullable', 'integer', 'min:1'],
            'status'                 => ['nullable', 'in:Minuta,Vigente,Suspenso,Encerrado,Rescindido'],
            'objeto'                 => ['nullable', 'string'],
            'observacoes'            => ['nullable', 'string'],
            'arquivo_path'           => ['nullable', 'string'],
        ];
    }
}
