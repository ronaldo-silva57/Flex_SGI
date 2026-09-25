<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class EsgMonitoramento extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'esg_monitoramentos';

    protected $fillable = [
        'esg_indicador_id',
        'responsavel_id',
        'periodo_referencia',
        'valor_realizado',
        'valor_meta',
        'analise',
        'status',
    ];

    protected $casts = [
        'periodo_referencia' => 'date',
        'valor_realizado' => 'decimal:2',
        'valor_meta' => 'decimal:2',
    ];

    /**
     * Relacionamentos
     */
    public function indicador()
    {
        return $this->belongsTo(EsgIndicador::class, 'esg_indicador_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}
