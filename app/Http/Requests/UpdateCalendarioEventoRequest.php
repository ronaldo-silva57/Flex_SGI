<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarioEventoRequest extends FormRequest
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
            'empresa_id'     => ['nullable', 'exists:empresas,id'],
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'titulo'         => ['nullable', 'string', 'max:255'],
            'descricao'      => ['nullable', 'string'],
            'data_inicio'    => ['nullable', 'date'],
            'data_fim'       => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'dia_inteiro'    => ['nullable', 'boolean'],
            'categoria'      => ['nullable', 'in:Auditoria,Prazo SGI,Reunião,Treinamento,Manutenção,Outros'],
            'cor'            => ['nullable', 'string', 'max:20'],
            'status'         => ['nullable', 'in:Agendado,Realizado,Cancelado,Adiado'],
        ];
    }
}
