<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVinculoNormativoRequest extends FormRequest
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
            'norma_id'              => ['required', 'exists:normas,id'],
            'clausula_id'           => ['required', 'exists:clausulas,id'],
            'processo_id'           => ['required', 'exists:processos,id'],
            'documento_id'          => ['nullable', 'exists:documentos,id'],
            'indicador_id'          => ['nullable', 'exists:indicadores,id'],
            'risco_id'              => ['nullable', 'exists:riscos_oportunidades,id'],
            'requisito_legal_id'    => ['nullable', 'exists:registros_legais,id'],
            'esg_indicador_id'      => ['nullable', 'exists:esg_indicadores,id'],
            'observacao'            => ['nullable', 'string'],
        ];
    }
}
