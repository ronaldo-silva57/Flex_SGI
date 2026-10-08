<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTreinamentoUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('treinamentos_usuario')?->id;

        return [
            'treinamento_id' => ['sometimes', 'exists:treinamentos,id'],
            'usuario_id'     => ['sometimes', 'exists:users,id'],
            'data_conclusao' => ['nullable', 'date'],
            'validade_ate'   => ['nullable', 'date', 'after_or_equal:data_conclusao'],
            'nota'           => ['nullable', 'numeric', 'min:0', 'max:10'],
            'certificado'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'status'         => ['sometimes', 'in:Pendente,Em andamento,Concluído,Vencido'],
        ];
    }
}