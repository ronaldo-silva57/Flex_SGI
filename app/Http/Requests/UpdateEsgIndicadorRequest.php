<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEsgIndicadorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'empresa_id'     => ['required', 'exists:empresas,id'],
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'dimensao'       => ['required', Rule::in(['Ambiental', 'Social', 'Governança'])],
            'codigo'         => ['required', 'string', 'max:50'],
            'nome'           => ['required', 'string', 'max:255'],
            'descricao'      => ['nullable', 'string'],
            'formula'        => ['nullable', 'string'],
            'meta'           => ['nullable', 'numeric', 'between:-99999999.99,99999999.99'],
            'unidade_medida' => ['nullable', 'string', 'max:50'],
            'frequencia'     => ['required', Rule::in(['Mensal', 'Trimestral', 'Semestral', 'Anual'])],
            'referencia_gri' => ['nullable', 'string', 'max:50'],
            'ativo'          => ['nullable', 'boolean'],
        ];
    }
}