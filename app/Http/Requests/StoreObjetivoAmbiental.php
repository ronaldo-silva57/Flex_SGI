<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreObjetivoAmbiental extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'codigo'                => ['required', 'string','max:50'],
            'titulo'                => ['required', 'string','max:255'],
            'descricao'             => ['nullable', 'string'],
            'indicador'             => ['nullable', 'string','max:255'],
            'meta'                  => ['nullable', 'numeric'],
            'unidade_medida'        => ['nullable', 'string','max:50'],
            'recursos_necessarios'  => ['nullable', 'string'],
            'responsaveis_execucao' => ['nullable', 'string'],
            'data_inicio'           => ['nullable', 'date'],
            'prazo'                 => ['nullable', 'date','after_or_equal:data_inicio'],
            'data_conclusao'        => ['nullable', 'date'],
            'progresso'             => ['nullable', 'integer','min:0','max:100'],
            'evidencia'             => ['nullable', 'string'],
            'status'                => ['required', 'in:Planejado,Em andamento,Concluído,Cancelado,Atrasado'],
            'responsavel_id'        => ['nullable', 'exists:users,id'],
            'aspecto_ambiental_id'  => ['nullable', 'exists:aspectos_ambientais,id'],
        ];
    }
}