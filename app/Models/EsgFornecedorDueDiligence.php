<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;
use App\Models\Stakeholder;
use App\Traits\Auditavel;

class EsgFornecedorDueDiligence extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'esg_fornecedores_due_diligence';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'stakeholder_id',
        'nome_fornecedor',
        'cnpj_fornecedor',
        'nivel_risco',
        'data_avaliacao',
        'possui_politica_anticorrupcao',
        'possui_trabalho_infantil_analise',
        'parecer_esg',
        'status_aprovacao',
    ];

    protected $casts = [
        'data_avaliacao'                    => 'date',
        'possui_politica_anticorrupcao'     => 'boolean',
        'possui_trabalho_infantil_analise'  => 'boolean',
    ];

    /**
     * Relacionamentos
     */

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function stakeholder(): BelongsTo
    {
        return $this->belongsTo(Stakeholder::class, 'stakeholder_id');
    }
}
