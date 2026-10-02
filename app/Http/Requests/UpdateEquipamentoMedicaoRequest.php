<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipamentoMedicaoRequest extends FormRequest
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
            'codigo'                        => ['sometimes', 'string', 'max:50'],
            'nome'                          => ['sometimes', 'string', 'max:255'],
            'marca'                         => ['nullable', 'string', 'max:100'],
            'modelo'                        => ['nullable', 'string', 'max:100'],
            'numero_serie'                  => ['nullable', 'string', 'max:100'],
            'faixa_medicao'                 => ['nullable', 'string', 'max:100'],
            'resolucao'                     => ['nullable', 'string', 'max:50'],
            'localizacao'                   => ['nullable', 'string', 'max:255'],
            'responsavel_id'                => ['nullable', 'exists:users,id'],
            'periodicidade_calibracao_meses'=> ['nullable', 'integer', 'min:1', 'max:120'],
            'ultima_calibracao'             => ['nullable', 'date'],
            'proxima_calibracao'            => ['nullable', 'date', 'after_or_equal:ultima_calibracao'],
            'status'                        => ['sometimes', 'in:Ativo,Em manutenção,Inativo,Descartado'],
        ];
    }
}
