<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Traits\Auditavel;

class MonitoramentoAmbiental extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'monitoramentos_ambientais';

    public const STATUS_NO_PRAZO = 'No prazo';
    public const STATUS_ATRASADO = 'Atrasado';
    public const STATUS_CONCLUIDO = 'Concluído';

    protected $fillable = [
        'indicador_ambiental_id',
        'responsavel_id',
        'periodo_referencia',
        'valor_realizado',
        'valor_meta',
        'analise',
        'acao_necessaria',
        'status',
    ];

    protected $casts = [
        'valor_realizado' => 'decimal:2',
        'valor_meta' => 'decimal:2',
    ];

    /**
     * Relacionamentos
     */

    public function indicadorAmbiental(): BelongsTo
    {
        return $this->belongsTo(IndicadorAmbiental::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}