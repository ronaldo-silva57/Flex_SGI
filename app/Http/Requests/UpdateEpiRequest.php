<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEpiRequest extends FormRequest
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
            'nome'              => ['sometimes', 'string', 'max:255'],
            'descricao'         => ['nullable', 'string'],
            'categoria'         => ['nullable', 'string', 'max:100'],
            'ca'                => ['nullable', 'string', 'max:50'],
            'validade_meses'    => ['nullable', 'integer', 'min:0'],
            'estoque_minimo'    => ['nullable', 'integer', 'min:0'],
            'estoque_atual'     => ['nullable', 'integer', 'min:0'],
            'ativo'             => ['boolean'],
        ];
    }
}
