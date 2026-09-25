<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMonitoramentoRequest extends FormRequest
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
            'indicador_id'       => ['required', 'exists:indicadores,id'],
            'responsavel_id'     => ['nullable', 'exists:users,id'],
            'periodo_referencia' => ['required', 'string', 'max:20'],
            'valor_realizado'    => ['nullable', 'numeric', 'between:-99999999.99,99999999.99'],
            'valor_meta'         => ['nullable', 'numeric', 'between:-99999999.99,99999999.99'],
            'analise'            => ['nullable', 'string'],
            'acao_necessaria'    => ['nullable', 'string'],
            'status'             => ['required', 'in:No prazo,Atrasado,Concluído'],
        ];
    }
}
