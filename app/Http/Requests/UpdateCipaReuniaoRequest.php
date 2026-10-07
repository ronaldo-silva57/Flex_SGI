<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCipaReuniaoRequest extends FormRequest
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
            'empresa_id'            => ['sometimes', 'exists:empresas,id'],
            'presidente_id'         => ['nullable', 'exists:users,id'],
            'secretario_id'         => ['nullable', 'exists:users,id'],
            'gestao_ano'            => ['required', 'string', 'regex:/^\d{4}\/\d{4}$/'],
            'tipo'                  => ['sometimes', 'in:Ordinária,Extraordinária,Inspeção de Campo,DDSGeral'],
            'data_reuniao'          => ['sometimes', 'date'],
            'pauta_principal'       => ['sometimes', 'string', 'max:255'],
            'pauta_detalhada'       => ['nullable', 'string'],
            'deliberacoes'          => ['nullable', 'string'],
            'ata_arquivo'           => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'status'                => ['sometimes', 'in:Agendada,Realizada,Cancelada'],
        ];
    }
}
