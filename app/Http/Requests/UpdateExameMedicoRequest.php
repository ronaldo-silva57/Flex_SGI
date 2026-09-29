<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExameMedicoRequest extends FormRequest
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
            'empresa_id'            => ['sometimes', 'exists:empresas,id'],
            'usuario_id'            => ['sometimes', 'exists:users,id'],
            'medico_examinador_id'  => ['nullable', 'exists:users,id'],
            'tipo_aso'              => ['sometimes', 'in:Admissional,Periódico,Retorno ao Trabalho,Mudança de Risco,Demissional'],
            'data_realizacao'       => ['sometimes', 'date'],
            'data_vencimento'       => ['nullable', 'date', 'after_or_equal:data_realizacao'],
            'resultado'             => ['sometimes', 'in:Apto,Apto com Restrição,Inapto'],
            'restricoes'            => ['nullable', 'string'],
            'crm_medico'            => ['nullable', 'string', 'max:30'],
            'medico_nome'           => ['nullable', 'string', 'max:255'],
            'arquivo_aso'           => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:5120'],
            'status'                => ['sometimes', 'in:Vigente,Vencido,Substituído'],
        ];
    }
}
