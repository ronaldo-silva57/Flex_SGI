<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartamentoRequest extends FormRequest
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
            'codigo'         => ['required', 'string', 'max:50',
                        Rule::unique('departamentos', 'codigo')->ignore($this->departamento->id),
                        ],   
            'nome'           => ['sometimes', 'required', 'string', 'max:255'],
            'descricao'      => ['nullable', 'string'],
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'ativo'          => ['boolean'],
        ];
    }
}
