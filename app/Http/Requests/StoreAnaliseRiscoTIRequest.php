<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnaliseRiscoTIRequest extends FormRequest
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
            'empresa_id' => ['required', 'exists:empresas,id',],
            'ativo_id' => ['required', 'exists:ativos_informacao,id',],
            'responsavel_id' => ['nullable', 'exists:users,id',],
            'ameaca' => ['required', 'string', 'max:255',],
            'vulnerabilidade' => ['required', 'string', 'max:255',],
            'afeta_confidencialidade' => ['nullable','boolean',],
            'afeta_integridade' => ['nullable', 'boolean',],
            'afeta_disponibilidade' => ['nullable', 'boolean',],
            'probabilidade' => ['required', 'integer', 'between:1,5',],
            'impacto' => ['required', 'integer', 'between:1,5',],
            'controles_existentes' => ['nullable', 'string',],
            'opcao_tratamento' => ['required', 'in:Mitigar, Transferir, Evitar, Aceitar',],
            'plano_tratamento' => ['nullable', 'string',],
            'probabilidade_residual' => ['nullable', 'integer', 'between:1,5',],
            'impacto_residual' => ['nullable', 'integer', 'between:1,5',
            ],

            'status' => ['required', 'in:Identificado,Em tratamento,Monitorado,Encerrado',
            ],
        ];
    }
}
