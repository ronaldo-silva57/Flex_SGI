<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnaliseCausaRespostaRequest extends FormRequest
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
            'analise_causa_id' => ['sometimes', 'required', 'exists:analises_causa,id'],
            'ordem'            => ['sometimes', 'required', 'integer', 'min:1', 'max:10'],
            'pergunta'         => ['sometimes', 'required', 'string', 'max:255'],
            'resposta'         => ['sometimes', 'required', 'string'],
            'evidencia'        => ['sometimes', 'nullable', 'string'],
            'eh_causa_raiz'    => ['sometimes', 'boolean'],
        ];
    }
}
