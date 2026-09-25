<?php

namespace App\Http\Requests;

use App\Models\LicencaAmbiental;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validação do upload do arquivo (PDF) da licença.
 *
 * Regras:
 *  - apenas PDF (é o formato usual de licenças de órgãos ambientais)
 *  - tamanho máximo de 10 MB
 *  - a licença precisa existir e o usuário precisa ter permissão de update
 */
class UploadLicencaAmbientalRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var LicencaAmbiental $licenca */
        $licenca = $this->route('licencaAmbiental');

        return $this->user()->can('update', $licenca);
    }

    public function rules(): array
    {
        return [
            // 'file' garante que é upload válido; 'mimes:pdf' valida extensão;
            // 'max:10240' = 10 MB em kilobytes.
            'arquivo' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'arquivo.required' => 'Selecione o arquivo da licença.',
            'arquivo.file'     => 'O arquivo enviado é inválido.',
            'arquivo.mimes'    => 'O arquivo deve estar no formato PDF.',
            'arquivo.max'      => 'O arquivo não pode ultrapassar 10 MB.',
        ];
    }
}