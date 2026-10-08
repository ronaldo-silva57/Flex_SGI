<?php

namespace App\Http\Requests;

use App\Models\LicencaAmbiental;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validação de edição de Licença Ambiental.
 *
 * Diferenças em relação ao Store:
 *  - authorize() recebe a instância vinda da rota (route model binding)
 *  - nenhuma regra muda de fato, mas mantemos a classe separada
 *    para o dia em que precisar (ex.: campo único que ignora o próprio ID).
 */

class UpdateLicencaAmbientalRequest extends FormRequest
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
            'numero'         => ['sometimes', 'string', 'max:100'],
            'tipo'           => ['sometimes', Rule::in(LicencaAmbiental::TIPOS)],
            'orgao_emissor'  => ['required', 'string', 'max:255'],
            'descricao'      => ['nullable', 'string'],
            'condicionantes' => ['nullable', 'string'],
            'data_emissao'   => ['sometimes', 'date'],
            'data_validade'  => ['sometimes', 'date', 'after:data_emissao'],
            'data_renovacao' => ['nullable', 'date'],
            'status'         => ['required', Rule::in([
                                    LicencaAmbiental::STATUS_VIGENTE,
                                    LicencaAmbiental::STATUS_VENCIDA,
                                    LicencaAmbiental::STATUS_EM_RENOVACAO,
                                    LicencaAmbiental::STATUS_SUSPENSA,
                                    LicencaAmbiental::STATUS_CANCELADA,
                                ])],
            'observacoes'    => ['nullable', 'string'],
            'responsavel_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

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
}
