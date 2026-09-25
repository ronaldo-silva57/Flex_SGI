<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClausulaRequest extends FormRequest
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
     */
    public function rules(): array
    {
        // Recupera a instância do model Clause injetada na rota (ex: /clausulas/{clausula})
        $clausula = $this->route('clausula');
        
        // Pega o norma_id do request (se estiver atualizando) ou o atual do banco
        $normaId = $this->input('norma_id', $clausula->norma_id);

        return [
            'norma_id'           => ['sometimes', 'required', 'exists:normas,id'],
            'codigo'             => [
                                        'sometimes',
                                        'required',
                                        'string',
                                        'max:20',
                                        // Verifica a unicidade da combinação (norma_id + codigo)
                                        Rule::unique('clausulas')->where(fn ($query) => 
                                            $query->where('norma_id', $normaId)
                                        )->ignore($clausula->id), // IGUALA ao ID da cláusula atual para não dar erro
                                    ],
            'titulo'            => ['sometimes', 'required', 'string', 'max:255'],
            'descricao'         => ['nullable', 'string'],
            'clausula_pai_id'   => ['nullable', 'exists:clausulas,id'],
            'ordem'             => ['nullable', 'integer', 'min:0'],
            'ativo'             => ['nullable', 'boolean'],
        ];
    }
}