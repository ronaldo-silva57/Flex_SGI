<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateControlesSegurancaRequest extends FormRequest
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
            'empresa_id'            => ['sometimes', 'exists:empresas,id'],
            'ativo_id'              => ['nullable', 'exists:ativos_informacao,id'],
            'codigo_anexo_a'        => ['nullable', 'string','max:20'],
            'titulo'                => ['sometimes', 'string','max:255'],
            'descricao'             => ['nullable', 'string'],
            'implementado'          => ['boolean'],
            'evidencia'             => ['nullable', 'string'],
            'responsavel_id'        => ['nullable', 'exists:users,id'],
            'data_implementacao'    => ['nullable', 'date'],
        ];
    }
}
