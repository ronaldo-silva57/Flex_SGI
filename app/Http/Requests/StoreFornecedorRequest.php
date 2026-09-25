<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'codigo'              => ['required', 'string', 'max:50'],
            'razao_social'        => ['required', 'string', 'max:255'],
            'nome_fantasia'       => ['nullable', 'string', 'max:255'],
            'cnpj'                => ['nullable', 'string', 'max:20', 'unique:fornecedores,cnpj'],
            'contato_nome'        => ['nullable', 'string', 'max:255'],
            'contato_email'       => ['nullable', 'email', 'max:255'],
            'contato_telefone'    => ['nullable', 'string', 'max:20'],
            'endereco'            => ['nullable', 'string'],
            'categoria'           => ['nullable', 'string', 'max:100'],
            'avaliacao_risco'     => ['nullable', 'integer', 'min:1', 'max:5'],
            'ativo'               => ['sometimes', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'razao_social.required' => 'A razão social é obrigatória.',
            'cnpj.unique'           => 'Este CNPJ já está cadastrado.',
            'avaliacao_risco.min'   => 'A avaliação de risco deve ser entre 1 e 5.',
            'avaliacao_risco.max'   => 'A avaliação de risco deve ser entre 1 e 5.',
        ];
    }
}