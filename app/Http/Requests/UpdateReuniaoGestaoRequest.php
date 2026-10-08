<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReuniaoGestaoRequest extends FormRequest
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
            'empresa_id'        => ['sometimes', 'exists:empresas,id'],
            'responsavel_id'    => ['nullable', 'exists:users,id'],
            'data_reuniao'      => ['sometimes', 'date'],
            'tipo'              => ['sometimes', 'in:Revisão Direção,Gestão Integrada,Outros'],
            'pauta'             => ['nullable', 'string'],
            'decisoes'          => ['nullable', 'string'],
            'acoes_definidas'   => ['nullable', 'string'],
            'proxima_reuniao'   => ['nullable', 'date'],
            'ata'               => ['nullable', 'string'],
        ];
    }
}
