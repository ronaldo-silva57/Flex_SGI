<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIndicadorRequest extends FormRequest
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
            'empresa_id'     => ['sometimes', 'required', 'exists:empresas,id'],
            'processo_id'    => ['nullable', 'exists:processos,id'],
            'norma_id'       => ['nullable', 'exists:normas,id'],
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'codigo'         => ['sometimes', 'required', 'string', 'max:50'],
            'nome'           => ['sometimes', 'required', 'string', 'max:255'],
            'descricao'      => ['nullable', 'string'],
            'formula'        => ['nullable', 'string'],
            'meta'           => ['nullable', 'numeric', 'between:-9999999999.99,9999999999.99'],
            'unidade_medida' => ['nullable', 'string'],
            'frequencia'     => ['nullable', 'in:Diária,Semanal,Mensal,Trimestral,Semestral,Anual'],
            'tipo_meta'      => ['nullable', 'in:Maior que,Menor que,Igual,Entre'],
            'ativo'          => ['boolean'],
        ];
    }
}
