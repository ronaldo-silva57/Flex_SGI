<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEsgRelatorioRequest extends FormRequest
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
            'empresa_id'        => ['sometimes', 'exists:empresas,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'titulo'            => ['sometimes', 'string'],
            'framework'         => ['nullable', 'in:GRI,SASB,TCFD,Global Compact,Outro'],
            'ano_referencia'    => ['nullable', 'integer'],
            'status'            => ['nullable', 'in:Rascunho,Em Revisão,Auditado,Publicado'],
            'data_publicacao'   => ['nullable', 'date'],
            'arquivo_path'      => ['nullable', 'string'],
            'observacoes'       => ['nullable', 'string'],
        ];
    }
}
