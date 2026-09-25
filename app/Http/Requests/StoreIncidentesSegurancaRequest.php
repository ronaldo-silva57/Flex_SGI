<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentesSegurancaRequest extends FormRequest
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
            'empresa_id'        => ['required','exists:empresas,id'],
            'ativo_id'          => ['nullable','exists:ativos_informacao,id'],
            'responsavel_id'    => ['nullable','exists:users,id'],
            'data_ocorrencia'   => ['required','date'],
            'tipo'              => ['required','in:Acesso não autorizado,Malware,Vazamento Dados,Indisponibilidade,Phishing,Outros'],
            'descricao'         => ['required','string'],
            'impacto'           => ['nullable','string'],
            'acao_imediata'     => ['nullable','string'],
            'investigacao'      => ['nullable','string'],
            'status'            => ['required','in:Aberto,Em investigação,Concluído'],
        ];
    }
}
