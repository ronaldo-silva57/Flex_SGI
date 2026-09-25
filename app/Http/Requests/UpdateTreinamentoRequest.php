<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTreinamentoRequest extends FormRequest
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
            'empresa_id'        => ['required', 'exists:empresas,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'titulo'            => ['required', 'string', 'max:255'],
            'descricao'         => ['nullable', 'string'],
            'conteudo'          => ['nullable', 'string'],
            'carga_horaria'     => ['nullable', 'integer', 'min:1'],
            'tipo'              => ['required', 'in:Obrigatório,Recomendado,Capacitação'],
            'validade_meses'    => ['nullable', 'integer', 'min:1'],
            'status'            => ['required', 'in:Ativo,Inativo'],   
        ];
    }
}
