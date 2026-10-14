<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Empresa;
use App\Traits\Auditavel;

class EsgDiversidade extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'esg_diversidade';

    protected $fillable = [
        'empresa_id',
        'ano_referencia',
        'categoria_cargo',
        'genero',
        'raca_etnia',
        'quantidade_colaboradores',
        'cargo_lideranca',
    ];

    protected $casts = [
        'ano_referencia'            => 'integer',
        'quantidade_colaboradores'  => 'integer',
        'cargo_lideranca'           => 'boolean',
    ];

    /**
     * Relacionamento
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
}
