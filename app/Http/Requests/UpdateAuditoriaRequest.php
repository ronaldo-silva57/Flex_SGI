<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuditoriaRequest extends FormRequest
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
            'empresa_id'       => ['required', 'exists:empresas,id'],
            'norma_id'         => ['nullable', 'exists:normas,id'],
            'auditor_lider_id' => ['nullable', 'exists:users,id'],
            'tipo'             => ['required', 'in:Interna,Externa,Terceira parte'],
            'escopo'           => ['nullable', 'string'],
            'objetivo'         => ['nullable', 'string'],
            'data_inicio'      => ['nullable', 'date'],
            'data_fim'         => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'status'           => ['required', 'in:Planejada,Em andamento,Concluída,Cancelada'],
            'relatorio'        => ['nullable', 'string'],
        ];
    }
}