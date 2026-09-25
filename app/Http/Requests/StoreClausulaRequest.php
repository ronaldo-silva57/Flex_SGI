<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClausulaRequest extends FormRequest
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
            'norma_id'          => ['required', 'exists:normas,id'],
            'codigo'            => [
                'required',
                'string',
                'max:20',
                Rule::unique('clausulas')->where(fn ($query) => 
                    $query->where('norma_id', $this->norma_id)
                ),
            ],
            'titulo'            => ['required', 'string', 'max:255'],
            'descricao'         => ['nullable', 'string'],
            'clausula_pai_id'   => ['nullable', 'exists:clausulas,id'],
            'ordem'             => ['nullable', 'integer', 'min:0'],
            'ativo'             => ['nullable', 'boolean'],
        ];
    }
}
