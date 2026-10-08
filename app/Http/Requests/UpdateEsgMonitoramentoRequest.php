<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEsgMonitoramentoRequest extends FormRequest
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
            'esg_indicador_id'      => ['sometimes', 'exists:esg_indicadores,id'],
            'responsavel_id'        => ['nullable', 'exists:users,id'],
            'periodo_referencia'    => ['sometimes', 'date'],
            'valor_realizado'       => ['nullable', 'numeric', 'between:-99999999.99,99999999.99'],
            'valor_meta'            => ['nullable', 'numeric', 'between:-99999999.99,99999999.99'],
            'analise'               => ['nullable', 'string'],
            'status'                => ['sometimes', Rule::in(['No prazo', 'Atrasado', 'Concluído'])],
        ];
    }
}
