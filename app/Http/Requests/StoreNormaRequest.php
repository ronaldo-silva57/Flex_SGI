<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreNormaRequest extends FormRequest
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
            'codigo'    => ['required', 'string', 'max:20', 'unique:normas,codigo'],
            'nome'      => ['required', 'string', 'max:255'],
            'versao'    => ['nullable', 'string','max:20'],
            'descricao' => ['nullable', 'string'],
            'ativo'     => ['nullable', 'boolean'],
        ];
    }

    #[Override]
    public function attributes()
    {
        return [
            'codigo'    => 'Código',
            'nome'      => 'Nome',
            'versao'    => 'Versão',
            'descricao' => 'Descrição',
            'ativo'     => 'Status Ativo',
        ];
    }
}
