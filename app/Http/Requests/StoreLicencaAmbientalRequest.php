<?php

namespace App\Http\Requests;

use App\Models\LicencaAmbiental;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreLicencaAmbientalRequest extends FormRequest
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
            'numero'        => ['required', 'string', 'max:100'],
            'tipo'          => ['required', Rule::in(LicencaAmbiental::TIPOS)],
            'orgao_emissor' => ['required', 'string', 'max:255'],
            'descricao'     => ['nullable', 'string'],
            'condicionantes'=> ['nullable', 'string'],

            'data_emissao'  => ['required', 'date'],
            'data_validade' => ['required', 'date', 'after:data_emissao'],
            'data_renovacao'=> ['nullable', 'date'],

            'status'        =>['required', Rule::in([
                LicencaAmbiental::STATUS_VIGENTE,
                LicencaAmbiental::STATUS_VENCIDA,
                LicencaAmbiental::STATUS_EM_RENOVACAO,
                LicencaAmbiental::STATUS_SUSPENSA,
                LicencaAmbiental::STATUS_CANCELADA,
            ])],

            'observacoes'   => ['nullable', 'string'],

            'responsavel_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    /**
     * Mensagens customizadas em pt-BR.
     * Útil para deixar o erro mais amigável do que o padrão do Laravel.
     */
    public function messages(): array
    {
        return [
            'numero.required'        => 'Informe o número da licença.',
            'tipo.required'          => 'Selecione o tipo de licença.',
            'tipo.in'                => 'Tipo de licença inválido.',
            'orgao_emissor.required' => 'Informe o órgão emissor.',
            'data_emissao.required'  => 'Informe a data de emissão.',
            'data_validade.required' => 'Informe a data de validade.',
            'data_validade.after'    => 'A validade deve ser posterior à data de emissão.',
            'status.in'              => 'Status inválido.',
            'responsavel_id.exists'  => 'Responsável não encontrado.',
        ];
    }

    /**
     * Nomes amigáveis dos campos (usados em :attribute nas mensagens).
     */
    public function attributes(): array
    {
        return [
            'numero'         => 'número',
            'orgao_emissor'  => 'órgão emissor',
            'data_emissao'   => 'data de emissão',
            'data_validade'  => 'data de validade',
            'data_renovacao' => 'data de renovação',
            'responsavel_id' => 'responsável',
        ];
    }

    /**
     * Normaliza os dados antes de aplicar as regras.
     * Ex.: trim em strings e remoção de campos vazios que viraram ''.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'numero'        => trim((string) $this->input('numero')),
            'orgao_emissor' => trim((string) $this->input('orgao_emissor')),
        ]);
    }
}
