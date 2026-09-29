<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\Auditavel;

class PlanoAcao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'planos_acao';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'origem_type',
        'origem_id',
        'codigo',
        'titulo',
        'o_que',
        'por_que',
        'onde',
        'como',
        'quanto_custa',
        'prazo_inicio',
        'prazo_fim',
        'data_conclusao',
        'progresso',
        'status',
        'eficaz',
        'evidencia_conclusao',
        'observacoes',
    ];

    protected $casts = [
        'prazo_inicio'      => 'date',
        'prazo_fim'         => 'date',
        'data_conclusao'    => 'date',
        'quanto_custa'      => 'decimal:2',
        'progresso'         => 'integer',
        'eficaz'            => 'boolean',
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

    /**
     * Origem polimórfica do plano de ação
     * 
     * Pode ser RNC, Risco, Auditoria, Reunião etc.
     */
    public function origem(): MorphTo
    {
        return $this->morphTo();
    }
}
