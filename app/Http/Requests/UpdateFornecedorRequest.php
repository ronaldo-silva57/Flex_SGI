<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFornecedorRequest extends FormRequest
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
        $fornecedorId = $this->route('fornecedor'); // ou $this->fornecedor

        return [
            'codigo'              => ['required', 'string', 'max:50'],
            'razao_social'        => ['required', 'string', 'max:255'],
            'nome_fantasia'       => ['nullable', 'string', 'max:255'],
            'cnpj'                => [
                                        'nullable',
                                        'string',
                                        'max:20',
                                        Rule::unique('fornecedores', 'cnpj')->ignore($fornecedorId),
                                    ],
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
            'empresa_id.exists'     => 'A empresa selecionada não existe.',
            'avaliacao_risco.min'   => 'A avaliação de risco deve ser no mínimo 1.',
            'avaliacao_risco.max'   => 'A avaliação de risco deve ser no máximo 5.',
        ];
    }
}