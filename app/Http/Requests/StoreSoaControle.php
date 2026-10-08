<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSoaControle extends FormRequest
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
            'empresa_id'                => ['required', 'integer', 'exists:empresas, id'],
            'responsavel_id'            => ['nullable', 'integer', 'exists:users,id'],
            'codigo_anexo_a'            => ['required', 'string', 'max:20',
                Rule::unique('soa_controles', 'codigo_anexo_a')->where(function ($query) {
                    return $query->where('empresa_id', $this->empresa_id);
                }),],
            'dominio'                   => ['required', 'string', 'max:100'],
            'titulo'                    => ['required', 'string', 'max:255'],
            'descricao'                 => ['nullable', 'string'],
            'aplicavel'                 => ['required', 'boolean'],
            'justificativa_inclusao'    => ['nullable','string','required_if:aplicavel true,1',],
            'justificativa_exclusao'    => ['nullable','string','required_if:aplicavel,false,0',],
            'status_implementacao'      => ['required', 
                Rule::in(['Não iniciado', 'Em implementacao', 'Implementado', 'Não aplicável'])
            ],
            'evidencia'                 => ['nullable', 'string'],
            'controle_id'               => ['nullable', 'integer', 'exists:controles_seguranca,id'],
        ];
    }

    /**
     * Preparar dados para validação (garante casting correto de booleanos).
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'aplicavel' => filter_var($this->aplicavel, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true,
        ]);
    }
}
