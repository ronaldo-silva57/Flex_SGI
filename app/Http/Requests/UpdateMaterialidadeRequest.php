<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMaterialidadeRequest extends FormRequest
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
            'empresa_id'                => ['required', 'exists:empresas,id'],
            'esg_indicador_id'          => ['nullable', 'exists:esg_indicadores,id'],
            'tema'                      => ['required', 'string', 'max:255'],
            'importancia_stakeholders'  => ['required', 'integer', 'between:1,5'],
            'importancia_negocio'       => ['required', 'integer', 'between:1,5'],
            'classificacao'             => ['nullable', Rule::in(['Baixa', 'Média', 'Alta', 'Crítica'])],
        ];
    }
}
