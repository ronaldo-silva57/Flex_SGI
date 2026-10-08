<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEpiUsuarioRequest extends FormRequest
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
            'epi_id'                => ['required', 'exists:epis,id'],
            'usuario_id'            => ['required', 'exists:users,id'],
            'data_entrega'          => ['nullable', 'date'],
            'data_vencimento'       => ['nullable', 'date', 'after_or_equal:data_entrega'],
            'quantidade'            => ['nullable', 'integer', 'min:1'],
            'responsavel_entrega_id'=> ['nullable', 'exists:users,id'],
            'status'                => ['required', 'in:Ativo,Vencido,Devolvido'],
        ];
    }

    public function messages()
    {
        return [
            'epi_id.required'                   => 'O EPI é obrigatório.',
            'usuario_id.required'               => 'O usuário é obrigatório.',
            'data_vencimento.after_or_equal'    => 'A data de vencimento deve ser posterior ou igual à data de entrega.',
            'quantidade.min'                    => 'A quantidade deve ser no mínimo 1.',
            'status.required'                   => 'O status é obrigatório.',
        ];
    }
}
