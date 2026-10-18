<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEsgGovernancaMembro extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [];
        if ($this->has('independente')) {
            $data['independente'] = $this->boolean('independente');
        }
        if ($this->has('ativo')) {
            $data['ativo'] = $this->boolean('ativo');
        }
        if (!empty($data)) {
            $this->merge($data);
        }
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
            'nome'              => ['sometimes', 'string'],
            'orgao'             =>['required', 'in:Conselho de Administração,Diretoria Executiva,Comitê de Auditoria,Comitê ESG,Outro'],
            'cargo'             => ['sometimes', 'string'],
            'independente'      => ['boolean'],
            'inicio_mandato'    => ['nullable', 'date'],
            'fim_mandato'       => ['nullable', 'date'],
            'ativo'             => ['boolean'],
        ];
    }
}
