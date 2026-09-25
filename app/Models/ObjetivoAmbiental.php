<?php

namespace App\Models;

use App\Traits\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjetivoAmbiental extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'objetivos_ambientais';

    public const STATUS_PLANEJADO    = 'Planejado';
    public const STATUS_EM_ANDAMENTO = 'Em andamento';
    public const STATUS_CONCLUIDO    = 'Concluído';
    public const STATUS_CANCELADO    = 'Cancelado';
    public const STATUS_ATRASADO     = 'Atrasado';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'aspecto_ambiental_id',
        'codigo',
        'titulo',
        'descricao',
        'indicador',
        'meta',
        'unidade_medida',
        'recursos_necessarios',
        'responsaveis_execucao',
        'data_inicio',
        'prazo',
        'data_conclusao',
        'progresso',
        'evidencia',
        'status',
    ];

    protected $casts = [
        'meta'           => 'decimal:2',
        'data_inicio'    => 'date',
        'prazo'          => 'date',
        'data_conclusao' => 'date',
        'progresso'      => 'integer',
    ];

    /**
     * Relacionamentos
     */

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function aspectoAmbiental(): BelongsTo
    {
        return $this->belongsTo(AspectoAmbiental::class);
    }

    /**
     * Scopos
     */

    public function scopePlanejados($query)
    {
        return $query->where('status', self::STATUS_PLANEJADO);
    }

    public function scopeEmAndamento($query)
    {
        return $query->where('status', self::STATUS_EM_ANDAMENTO);
    }

    public function scopeConcluidos($query)
    {
        return $query->where('status', self::STATUS_CONCLUIDO);
    }

    public function scopeAtrasados($query)
    {
        return $query->where('status', self::STATUS_ATRASADO);
    }

    public function scopeDaEmpresa($query, int $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    public function scopeVencendoEm($query, int $dias = 30)
    {
        return $query->whereNull('data_conclusao')
                     ->whereBetween('prazo', [
                         now()->toDateString(),
                         now()->addDays($dias)->toDateString(),
                     ]);
    }

    /**
     * Acessores
     */

    public function getDiasAtePrazoAttribute(): ?int
    {
        if (! $this->prazo) {
            return null;
        }
        return now()->startOfDay()->diffInDays($this->prazo, false);
    }
}