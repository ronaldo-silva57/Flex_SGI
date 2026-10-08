<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocumentoRequest extends FormRequest
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
        $documento = $this->route('documento');

        return [
            'empresa_id'        => ['sometimes', 'exists:empresas,id'],
            'processo_id'       => ['nullable', 'exists:processos,id'],
            'norma_id'          => ['nullable', 'exists:normas,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'codigo'            => ['sometimes', 'string', 'max:50',
                                    Rule::unique('documentos', 'codigo')->ignore($documento->id),
                                ],
            'titulo'            => ['sometimes', 'string', 'max:255'],
            'tipo'              => ['sometimes', 'in:Política,Procedimento,Instrução,Registro,Formulário,Manual,Outro'],
            'versao'            => ['sometimes', 'string', 'max:10'],
            'conteudo'          => ['nullable', 'string'],
            'arquivo_path'      => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg', 'max:10240'],
            'status'            => ['sometimes', 'in:Rascunho,Em revisão,Aprovado,Obsoleto'],
            'data_aprovacao'    => ['nullable', 'date'],
            'data_revisao'      => ['nullable', 'date'],
        ];
    }
}
