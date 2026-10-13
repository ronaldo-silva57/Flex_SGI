<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjetoRequest extends FormRequest
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
            'empresa_id'           => ['nullable', 'exists:empresas,id'],
            'responsavel_id'       => ['nullable', 'exists:users,id'],
            'codigo'               => ['nullable', 'string', 'max:50'],
            'nome'                 => ['nullable', 'string', 'max:255'],
            'descricao'            => ['nullable', 'string'],
            'data_inicio'          => ['nullable', 'date'],
            'data_fim_prevista'    => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'data_fim_real'        => ['nullable', 'date'],
            'status'               => ['nullable', 'in:Planejamento,Em andamento,Suspenso,Concluído,Cancelado'],
            'progresso_percentual' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }
}
