<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePesquisaSatisfacaoRequest extends FormRequest
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
            'codigo'            => ['sometimes', 'string', 'max:40'],
            'titulo'            => ['sometimes', 'string', 'max:255'],
            'descricao'         => ['nullable', 'string'],
            'tipo'              => ['sometimes', 'in:NPS,CSAT,Personalizada'],
            'canal'             => ['nullable', 'in:Email,Telefone,Presencial,Online'],
            'cliente_id'        => ['nullable', 'exists:clientes,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'data_inicio'       => ['sometimes', 'date'],
            'data_fim'          => ['nullable', 'date'],
            'status'            => ['sometimes', 'in:Planejada,Em andamento,Concluída,Cancelada'],
        ];
    }
}
