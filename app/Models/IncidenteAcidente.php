<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class IncidenteAcidente extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'incidentes_acidentes';

    protected $fillable = [
        'empresa_id',
        'usuario_id',
        'responsavel_id',
        'data_ocorrencia',
        'local',
        'tipo',
        'descricao',
        'causas',
        'lesao',
        'dias_perdidos',
        'tratamento',
        'investigacao',
        'acao_corretiva',
        'status',
    ];

    protected $casts = [
        'data_ocorrencia' => 'date',
        'dias_perdidos' => 'integer',
    ];

    /***
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}
