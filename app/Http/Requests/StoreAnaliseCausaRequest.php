<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnaliseCausaRequest extends FormRequest
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
            'nao_conformidade_id' => ['required', 'exists:nao_conformidades,id'],
            'responsavel_id'      => ['nullable', 'exists:users,id'],
            'metodo'              => ['required', 'string', 'max:40'],
            'status'              => ['nullable', 'string', 'max:30'],
            'objetivo'            => ['nullable', 'string'],
            'conclusao'           => ['nullable', 'string'],
            'data_inicio'         => ['nullable', 'date'],
            'data_conclusao'      => ['nullable', 'date'],
        ];
    }
}
