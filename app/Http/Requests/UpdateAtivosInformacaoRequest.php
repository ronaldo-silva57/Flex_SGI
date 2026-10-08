<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAtivosInformacaoRequest extends FormRequest
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
            'empresa_id'        => ['sometimes', 'exists:empresas,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'nome'              => ['sometimes', 'string','max:255'],
            'descricao'         => ['nullable', 'string'],
            'tipo'              => ['sometimes', 'in:Hardware,Software,Dados,Servico,Pessoas,Instalações,Intangível'],
            'localizacao'       => ['nullable', 'string','max:255'],
            'proprietario_id'   => ['nullable', 'exists:users,id'],
            'classificacao'     => ['nullable', 'in:Público,Interno,Confidencial,Restrito'],
            'valor'             => ['nullable', 'numeric','min:0'],
            'status'            => ['sometimes', 'in:Ativo,Inativo,Descartado'],
        ];
    }
}
