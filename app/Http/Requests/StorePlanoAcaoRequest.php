<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlanoAcaoRequest extends FormRequest
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
            'empresa_id'            => ['nullable', 'exists:empresas,id'],
            'responsavel_id'        => ['nullable', 'integer', 'exists:users,id'],
            'origem_type'           => ['nullable', 'string'],
            'origem_id'             => ['nullable', 'integer', 'required_with:origem_type'],
            
            'codigo'                => ['nullable', 'string', 'max:50'],
            'titulo'                => ['required', 'string', 'max:255'],
            'o_que'                 => ['required', 'string'],
            'por_que'               => ['nullable', 'string'],
            'onde'                  => ['nullable', 'string'],
            'como'                  => ['nullable', 'string'],
            'quanto_custa'          => ['nullable', 'numeric', 'min:0'],
            'prazo_inicio'          => ['nullable', 'date'],
            'prazo_fim'             => ['nullable', 'date', 'after_or_equal:prazo_inicio'],
            'data_conclusao'        => ['nullable', 'date'],
            'progresso'             => ['nullable', 'integer', 'between:0,100'],
            'status'                => ['nullable', Rule::in(['Pendente', 'Em andamento', 'Em verificação', 'Concluído', 'Cancelado'])],
            'eficaz'                => ['nullable', 'boolean'],
            'evidencia_conclusao'   => ['nullable', 'string'],
            'observacoes'           => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Limpa e trata o valor monetário caso venha formatado em BRL (ex: "1.250,50" -> "1250.50")
        $quantoCusta = $this->quanto_custa;
        if (is_string($quantoCusta)) {
            $quantoCusta = str_replace(['.', ','], ['', '.'], $quantoCusta);
        }

        $this->merge([
            // Injeta empresa_id do usuário logado caso não venha no request
            'empresa_id'   => $this->empresa_id ?? auth()->user()?->empresa_id,
            'quanto_custa' => is_numeric($quantoCusta) ? (float) $quantoCusta : 0,
            'progresso'    => $this->progresso ?? 0,
            'status'       => $this->status ?? 'Pendente',
        ]);
    }
}
