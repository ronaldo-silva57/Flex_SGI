<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreReuniaoGestaoRequest extends FormRequest
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
            'data_reuniao'      => ['required', 'date'],
            'tipo'              => ['required', 'in:Revisão Direção,Gestão Integrada,Outros'],
            'pauta'             => ['nullable', 'string'],
            'decisoes'          => ['nullable', 'string'],
            'acoes_definidas'   => ['nullable', 'string'],
            'proxima_reuniao'   => ['nullable', 'date'],
            'ata'               => ['nullable', 'string'],
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'data_reuniao.required' => 'A data da reunião é obrigatória.',
            'tipo.required'         => 'O tipo é obrigatório.',
            'tipo.in'               => 'Tipo inválido.',
        ];
    }
}
