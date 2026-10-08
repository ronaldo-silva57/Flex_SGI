<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEpiUsuarioRequest extends FormRequest
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
            'epi_id'                => ['sometimes', 'exists:epis,id'],
            'usuario_id'            => ['sometimes', 'exists:users,id'],
            'data_entrega'          => ['nullable', 'date'],
            'data_vencimento'       => ['nullable', 'date|after_or_equal:data_entrega'],
            'quantidade'            => ['nullable', 'integer|min:1'],
            'responsavel_entrega_id'=> ['nullable', 'exists:users,id'],
            'status'                => ['sometimes', 'in:Ativo,Vencido,Devolvido'],
        ];
    }
}
