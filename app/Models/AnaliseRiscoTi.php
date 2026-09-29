<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class AnaliseRiscoTi extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'analises_risco_ti';

    protected $fillable = [
        'empresa_id',
        'ativo_id',
        'responsavel_id',
        'ameaca',
        'vulnerabilidade',
        'afeta_confidencialidade',
        'afeta_integridade',
        'afeta_disponibilidade',
        'probabilidade',
        'impacto',
        'controles_existentes',
        'opcao_tratamento',
        'plano_tratamento',
        'probabilidade_residual',
        'impacto_residual',
        'status',
    ];

    protected $casts = [
        'afeta_confidencialidade' => 'boolean',
        'afeta_integridade' => 'boolean',
        'afeta_disponibilidade' => 'boolean',
        'probabilidade' => 'integer',
        'impacto' => 'integer',
        'nivel_risco_inerente' => 'integer',
        'probabilidade_residual' => 'integer',
        'impacto_residual' => 'integer',
        'nivel_risco_residual' => 'integer',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function ativo(): BelongsTo
    {
        return $this->belongsTo(AtivoInformacao::class, 'ativo_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}
