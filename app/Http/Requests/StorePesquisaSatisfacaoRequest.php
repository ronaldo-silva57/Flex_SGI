<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StorePesquisaSatisfacaoRequest extends FormRequest
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
            'codigo'            => ['required', 'string', 'max:40'],
            'titulo'            => ['required', 'string', 'max:255'],
            'descricao'         => ['nullable', 'string'],
            'tipo'              => ['required', 'in:NPS,CSAT,Personalizada'],
            'canal'             => ['nullable', 'in:Email,Telefone,Presencial,Online'],
            'cliente_id'        => ['nullable', 'exists:clientes,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'data_inicio'       => ['required', 'date'],
            'data_fim'          => ['nullable', 'date'],
            'status'            => ['required', 'in:Planejada,Em andamento,Concluída,Cancelada'],
        ];
    }

    public function attributes(): array
    {
        return [
            'codigo'      => 'código',
            'titulo'      => 'título',
            'data_inicio' => 'data de início',
            'data_fim'    => 'data de encerramento',
        ];
    }
}
