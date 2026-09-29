<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlanoAcaoRequest extends FormRequest
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
            'responsavel_id'        => ['nullable', 'integer', 'exists:users,id',],
            'origem_type'           => ['nullable', 'string', Rule::in(['rnc','risco','auditoria','reuniao',]),],
            'origem_id'             => ['nullable', 'integer', 'required_with:origem_type',],
            'codigo'                => ['nullable', 'string', 'max:50',],
            'titulo'                => ['sometimes', 'string', 'max:255',],
            'o_que'                 => ['sometimes', 'string',],
            'por_que'               => ['nullable', 'string',],
            'onde'                  => ['nullable', 'string',],
            'como'                  => ['nullable', 'string',],
            'quanto_custa'          => ['nullable', 'numeric', 'min:0',],
            'prazo_inicio'          => ['nullable', 'date',],
            'prazo_fim'             => ['nullable', 'date',],
            'data_conclusao'        => ['nullable', 'date',],
            'progresso'             => ['nullable', 'integer', 'between:0,100',],
            'status'                => [ 'nullable', Rule::in(['Pendente','Em andamento','Em verificação','Concluído','Cancelado',]),],
            'eficaz'                => ['nullable', 'boolean',],
            'evidencia_conclusao'   => ['nullable', 'string',],
            'observacoes'           => ['nullable', 'string',],
        ];
}


