<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePesquisaRespostaRequest extends FormRequest
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
            'pesquisa_id'          => ['required', 'exists:pesquisas_satisfacao,id'],
            'cliente_id'           => ['nullable', 'exists:clientes,id'],
            'respondente_id'       => ['nullable', 'exists:users,id'],
            'nota'                 => ['required', 'numeric', 'min:0', 'max:10'],
            'comentario'           => ['nullable', 'string'],
            'respostas_detalhadas' => ['nullable', 'array'],
            'respondido_em'        => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Se houver um comentário avulso e nenhum array estruturado, insere no JSON
        if ($this->has('comentario') && !$this->has('respostas_detalhadas.comentario')) {
            $detalhes = $this->input('respostas_detalhadas', []);
            $detalhes['comentario'] = $this->input('comentario');
            $this->merge(['respostas_detalhadas' => $detalhes]);
        }
    }

    public function attributes(): array
    {
        return [
            'pesquisa_id' => 'pesquisa de satisfação',
            'nota'        => 'nota',
        ];
    }
}
