<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExameMedicoRequest extends FormRequest
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
            'empresa_id'            => ['required', 'exists:empresas,id'],
            'usuario_id'            => ['required', 'exists:users,id'],
            'medico_examinador_id'  => ['nullable', 'exists:users,id'],
            'tipo_aso'              => ['required', 'in:Admissional,Periódico,Retorno ao Trabalho,Mudança de Risco,Demissional'],
            'data_realizacao'       => ['required', 'date'],
            'data_vencimento'       => ['nullable', 'date', 'after_or_equal:data_realizacao'],
            'resultado'             => ['required', 'in:Apto,Apto com Restrição,Inapto'],
            'restricoes'            => ['nullable', 'string'],
            'crm_medico'            => ['nullable', 'string', 'max:30'],
            'medico_nome'           => ['nullable', 'string', 'max:255'],
            'arquivo_aso'           => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:5120'],
            'status'                => ['required', 'in:Vigente,Vencido,Substituído'],
        ];
    }
}
