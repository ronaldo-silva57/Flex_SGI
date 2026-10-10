<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventarioGeeRequest extends FormRequest
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
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('inventario_gee', 'codigo')
                    ->where(fn ($query) => $query->where('empresa_id', $empresaId)),
            ],
            'ano_referencia'    => ['required', 'integer', 'digits:4', 'min:1900', 'max:2100'],
            'escopo'            => ['required', Rule::in(['1', '2', '3'])],
            'categoria'         => ['nullable', 'string', 'max:150'],
            'fonte_emissao'     => ['required', 'string', 'max:255'],
            'quantidade'        => ['nullable', 'numeric', 'min:0'],
            'unidade'           => ['nullable', 'string', 'max:30'],
            'fator_emissao'     => ['nullable', 'numeric', 'min:0'],
            'emissao_tco2e'     => ['required', 'numeric', 'min:0'],
            'metodologia'       => ['nullable', 'string'],
            'referencia_fator'  => ['nullable', 'string', 'max:255'],
            'evidencia'         => ['nullable', 'string'],
            'status'            => ['required', Rule::in(['Rascunho', 'Em revisão', 'Verificado', 'Publicado'])],
        ];
    }
}
