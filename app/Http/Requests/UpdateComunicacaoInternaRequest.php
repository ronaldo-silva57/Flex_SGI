<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateComunicacaoInternaRequest extends FormRequest
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
            'empresa_id'    => ['nullable', 'exists:empresas,id'],
            'autor_id'      => ['nullable', 'exists:users,id'],
            'titulo'        => ['nullable', 'string', 'max:255'],
            'conteudo'      => ['nullable', 'string'],
            'tipo'          => ['nullable', 'in:Aviso,Circular,Política SGI,Comunicado Oficial'],
            'exige_ciencia' => ['nullable', 'boolean'],
            'publicado_em'  => ['nullable', 'date'],
            'expira_em'     => ['nullable', 'date', 'after_or_equal:publicado_em'],
            'ativo'         => ['nullable', 'boolean'],
        ];
    }
}
