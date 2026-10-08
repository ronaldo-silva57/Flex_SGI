<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoRequest extends FormRequest
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
            'processo_id'       => ['nullable', 'exists:processos,id'],
            'norma_id'          => ['nullable', 'exists:normas,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'codigo'            => ['required', 'string', 'max:50', 'unique:documentos,codigo'],
            'titulo'            => ['required', 'string', 'max:255'],
            'tipo'              => ['required', 'in:Política,Procedimento,Instrução,Registro,Formulário,Manual,Outro'],
            'versao'            => ['required', 'string', 'max:10'],
            'conteudo'          => ['nullable', 'string'],
            'arquivo_path'      => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg', 'max:10240'], // até 10MB
            'status'            => ['required', 'in:Rascunho,Em revisão,Aprovado,Obsoleto'],
            'data_aprovacao'    => ['nullable', 'date'],
            'data_revisao'      => ['nullable', 'date'],
        ];
    }

    public function messages()
    {
        return [
            'codigo.required'   => 'O código é obrigatório.',
            'codigo.unique'     => 'Este código já está em uso.',
            'titulo.required'   => 'O título é obrigatório.',
            'tipo.required'     => 'O tipo é obrigatório.',
            'status.required'   => 'O status é obrigatório.',
        ];
    }   
}
