<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateEmpresaRequest extends FormRequest
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
        $empresaId = $this->route('empresa')?->id ?? $this->route('empresa');

        return [
            'razao_social'  => ['required', 'string', 'max:255'],
            'codigo'        => ['required', 'string', 'max:50'],
            'nome_fantasia' => ['nullable', 'string', 'max:255'],
            'cnpj'          => ['nullable', 'string', 'max:20', Rule::unique('empresas', 'cnpj')->ignore($empresaId)],
            'ie'            => ['nullable', 'string', 'max:20'],
            'endereco'      => ['nullable', 'string'],
            'cidade'        => ['nullable', 'string', 'max:100'],
            'estado'        => ['nullable', 'string', 'size:2'],
            'cep'           => ['nullable', 'string', 'max:10'],
            'telefone'      => ['nullable', 'string', 'max:20'],
            'email'         => ['nullable', 'email', 'max:255'],
            'ativo'         => ['boolean'],
        ];
    }
}