<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIncidenteAcidenteRequest extends FormRequest
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
            'empresa_id'        => 'required|exists:empresas,id',
            'usuario_id'        => 'nullable|exists:users,id',
            'responsavel_id'    => 'nullable|exists:users,id',
            'data_ocorrencia'   => 'required|date',
            'local'             => 'nullable|string|max:255',
            'tipo'              => 'required|in:Quase acidente,Incidente,Acidente leve,Acidente grave,Fatal',
            'descricao'         => 'required|string',
            'causas'            => 'nullable|string',
            'lesao'             => 'nullable|string',
            'dias_perdidos'     => 'nullable|integer|min:0',
            'tratamento'        => 'nullable|string',
            'investigacao'      => 'nullable|string',
            'acao_corretiva'    => 'nullable|string',
            'status'            => 'required|in:Aberto,Em investigação,Concluído',
        ];
    }
}
