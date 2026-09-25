<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory as FactoriesHasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditavel;

class Materialidade extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'materialidade';

    protected $fillable = [
        'empresa_id',
        'esg_indicador_id',
        'tema',
        'importancia_stakeholders',
        'importancia_negocio',
        'score',
        'classificacao',
    ];

    protected $casts = [
        'importancia_stakeholders' => 'integer',
        'importancia_negocio' => 'integer',
        'score' => 'integer',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function esgIndicador(): BelongsTo
    {
        return $this->belongsTo(EsgIndicador::class);
    }
}
