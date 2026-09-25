<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreinamentoUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'treinamento_id'   => ['required', 'exists:treinamentos,id'],
            'usuario_id'       => ['required', 'exists:users,id'],
            'data_conclusao'   => ['nullable', 'date'],
            'validade_ate'     => ['nullable', 'date', 'after_or_equal:data_conclusao'],
            'nota'             => ['nullable', 'numeric', 'min:0', 'max:10'],
            'certificado'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'status'           => ['required', 'in:Pendente,Em andamento,Concluído,Vencido'],
        ];
    }

    public function messages(): array
    {
        return [
            'treinamento_id.required'       => 'Selecione o treinamento.',
            'usuario_id.required'           => 'Selecione o usuário.',
            'validade_ate.after_or_equal'   => 'A validade deve ser igual ou posterior à data de conclusão.',
            'nota.max'                      => 'A nota não pode ser maior que 10.',
        ];
    }
}