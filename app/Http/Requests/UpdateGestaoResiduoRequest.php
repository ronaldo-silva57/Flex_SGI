<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGestaoResiduoRequest extends FormRequest
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
            'processo_id'           => ['nullable', 'exists:processos,id'],
            'responsavel_id'        => ['nullable', 'exists:users,id'],
            'codigo'                => ['sometimes', 'string', 'max:50'],
            'descricao'             => ['sometimes', 'string', 'max:255'],
            'classe'                => ['nullable', 'in:Classe I,Classe II-A,Classe II-B'],
            'tipo'                  => ['sometimes','in:Reciclável,Não reciclável,Perigoso,Inerte,Orgânico,Outros'],
            'fonte_geradora'        => ['nullable', 'string', 'max:255'],
            'quantidade_gerada'     => ['nullable', 'numeric', 'min:0'],
            'unidade_medida'        => ['nullable', 'string', 'max:20'],
            'frequencia_geracao'    => ['nullable', 'in:Diária,Semanal,Mensal,Trimestral,Semestral,Anual,Esporádica'],
            'forma_armazenamento'   => ['nullable', 'string'],
            'destino_final'         => ['nullable','in:Reutilização,Reciclagem,Coprocessamento,Aterro Industrial,Aterro Sanitário,Incineração,Compostagem,Outros'],
            'transportador'         => ['nullable', 'string', 'max:255'],
            'destinador'            => ['nullable', 'string', 'max:255'],
            'numero_mtr'            => ['nullable', 'string', 'max:100'],
            'observacoes'           => ['nullable', 'string'],
            'status'                => ['sometimes', 'in:Ativo,Inativo'],
        ];
    }
}
