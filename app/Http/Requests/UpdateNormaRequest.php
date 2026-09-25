<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNormaRequest extends FormRequest
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
        //Pega a norma sendo atualizada diretamente da Rota
        $norma = $this->route('norma');
        return [
            'codigo'    => [
                                'required',
                                'string',
                                'max:20',
                                // Ignora o ID da própria norma sendo editada
                                Rule::unique('normas', 'codigo')->ignore($norma->id),
                            ],
            'nome'      => ['required', 'string', 'max:255'],
            'versao'    => ['nullable', 'string', 'max:20'],
            'descricao' => ['nullable', 'string'],
            'ativo'     => ['nullable', 'boolean'],
        ];
    }
}
