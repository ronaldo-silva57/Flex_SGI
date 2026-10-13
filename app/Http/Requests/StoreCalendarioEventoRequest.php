<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreCalendarioEventoRequest extends FormRequest
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
            'empresa_id'     => ['nullable', 'exists:empresas,id'],
            'responsavel_id' => ['nullable', 'exists:users,id'],
            'titulo'         => ['required', 'string', 'max:255'],
            'descricao'      => ['nullable', 'string'],
            'data_inicio'    => ['required', 'date'],
            'data_fim'       => ['nullable', 'date', 'after_or_equal:data_inicio'],
            'dia_inteiro'    => ['nullable', 'boolean'],
            'categoria'      => ['required', 'in:Auditoria,Prazo SGI,Reunião,Treinamento,Manutenção,Outros'],
            'cor'            => ['nullable', 'string', 'max:20'],
            'status'         => ['nullable', 'in:Agendado,Realizado,Cancelado,Adiado'],
        ];
    }

    #[Override]
    protected function prepareForValidation()
    {
        if (empty($this->empresa_id)) {
            $this->merge([
                'empresa_id' => auth()->user()->empresa_id ?? null,
            ]);
        }

        if (empty($this->responsavel_id)) {
            $this->merge([
                'responsavel_id' => auth()->id(),
            ]);
        }
    }
}
