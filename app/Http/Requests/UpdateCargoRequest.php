<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCargoRequest extends FormRequest
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
            'empresa_id'      => ['nullable', 'exists:empresas,id'],
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'codigo'          => ['nullable', 'string', 'max:50'],
            'nome'            => ['nullable', 'string', 'max:255'],
            'descricao'       => ['nullable', 'string'],
            'requisitos'      => ['nullable', 'string'],
            'ativo'           => ['nullable', 'boolean'],
        ];
    }
}
