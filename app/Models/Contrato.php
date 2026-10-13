<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class Contrato extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'contratos';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'fornecedor_id',
        'responsavel_id',
        'numero_contrato',
        'titulo',
        'tipo',
        'valor_total',
        'data_inicio',
        'data_fim',
        'alerta_vencimento_dias',
        'status',
        'objeto',
        'observacoes',
        'arquivo_path',
    ];

    protected $casts = [
        'data_inicio'               => 'date',
        'data_fim'                  => 'date',
        'valor_total'               => 'decimal:6',
        'alerta_vencimento_dias'    => 'integer',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}
