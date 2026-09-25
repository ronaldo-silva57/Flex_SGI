<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistroLegalRequest extends FormRequest
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
            'empresa_id'       => ['required', 'exists:empresas,id'],
            'norma_id'         => ['nullable', 'exists:normas,id'],
            'numero'           => ['nullable', 'string', 'max:100'],
            'orgao'            => ['nullable', 'string', 'max:255'],
            'descricao'        => ['required',' string'],
            'tipo'             => ['required', 'in:Lei,Decreto,Normativa,Convênio,Resolução'],
            'data_publicacao'  => ['nullable', 'date'],
            'data_vigencia'    => ['nullable', 'date', 'after_or_equal:data_publicacao'],
            'status'           => ['required', 'in:Vigente,Revogado,Em revisão'],
            'arquivo_path'     => ['nullable', 'string', 'max:500'],
        ];
    }
    public function messages()
    {
        return [
            'empresa_id.required'           => 'A empresa é obrigatória.',
            'descricao.required'            => 'A descrição é obrigatória.',
            'tipo.required'                 => 'O tipo é obrigatório.',
            'tipo.in'                       => 'Tipo inválido.',
            'status.required'               => 'O status é obrigatório.',
            'data_vigencia.after_or_equal'  => 'A data de vigência deve ser posterior ou igual à data de publicação.',
        ];
    }    
}
