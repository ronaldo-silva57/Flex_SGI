<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCalibracaoRequest extends FormRequest
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
            'equipamento_id'        => ['sometimes', 'exists:equipamentos_medicao,id'],
            'responsavel_id'        => ['nullable', 'exists:users,id'],
            'data_calibracao'       => ['sometimes', 'date'],
            'data_validade'         => ['sometimes', 'date', 'after_or_equal:data_calibracao'],
            'laboratorio'           => ['nullable', 'string', 'max:255'],
            'certificado_numero'    => ['nullable', 'string', 'max:100'],
            'certificado'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'], // 10MB
            'resultado'             => ['sometimes', 'in:Aprovado,Aprovado com restrição,Reprovado'],
            'observacoes'           => ['nullable', 'string'],
        ];
    }
}
