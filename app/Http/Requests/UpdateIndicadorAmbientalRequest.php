<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIndicadorAmbientalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo'         => ['sometimes','string','max:50'],
            'nome'           => ['sometimes','string','max:255'],
            'descricao'      => ['nullable','string'],
            'categoria'      => ['required','in:Emissões Atmosféricas,Recursos Hídricos,Energia,Resíduos,Biodiversidade,Uso do Solo,Ruído,Outros'],
            'formula'        => ['nullable','string'],
            'meta'           => ['nullable','numeric'],
            'unidade_medida' => ['nullable','string','max:50'],
            'frequencia'     => ['nullable','in:Mensal,Trimestral,Semestral,Anual'],
            'tipo_meta'      => ['nullable','in:Maior que,Menor que,Igual a,Entre'],
            'ativo'          => ['nullable','boolean'],
            'responsavel_id' => ['nullable','exists:users,id'],
        ];
    }
}
