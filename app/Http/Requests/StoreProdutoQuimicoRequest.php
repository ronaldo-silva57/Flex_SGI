<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoQuimicoRequest extends FormRequest
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
            'nome'                   => ['required', 'string', 'max:255'],
            'fabricante'             => ['nullable', 'string', 'max:255'],
            'numero_fispq'           => ['nullable', 'string', 'max:100'],
            'numero_cas'             => ['nullable', 'string', 'max:50'],
            'estado_fisico'          => ['nullable', 'in:Sólido,Líquido,Gasoso,Pastoso,Outros'],
            'composicao'             => ['nullable', 'string'],
            'perigos_ghs'            => ['nullable', 'string'],
            'palavra_advertencia'    => ['nullable', 'string', 'max:100'],
            'pictogramas'            => ['nullable', 'string'],
            'primeiros_socorros'     => ['nullable', 'string'],
            'combate_incendio'       => ['nullable', 'string'],
            'medidas_derramamento'   => ['nullable', 'string'],
            'manuseio_armazenamento' => ['nullable', 'string'],
            'epi_necessario'         => ['nullable', 'string'],
            'epc_necessario'         => ['nullable', 'string'],
            'localizacao'            => ['nullable', 'string', 'max:255'],
            'quantidade_estoque'     => ['nullable', 'numeric'],
            'unidade_medida'         => ['nullable', 'string', 'max:20'],
            'data_validade'          => ['nullable', 'date'],
            'status'                 => ['required', 'in:Ativo,Inativo,Descontinuado'],
            'fornecedor_id'          => ['nullable', 'exists:fornecedores,id'],
            'responsavel_id'         => ['nullable', 'exists:users,id'],
        ];
    }
}
