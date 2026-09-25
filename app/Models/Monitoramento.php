<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditavel;

class Monitoramento extends Model
{
    use HasFactory, SoftDeletes, Auditavel;
    
    protected $table = 'monitoramentos';

    protected $fillable = [
        'indicador_id',
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
        'valor_meta'      => 'decimal:2',
    ];

    /**
     * Relacionamentos
     */
    public function indicador(): BelongsTo
    {
        return $this->belongsTo(Indicador::class, 'indicador_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}
