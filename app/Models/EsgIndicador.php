<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class EsgIndicador extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'esg_indicadores';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'dimensao',
        'codigo',
        'nome',
        'descricao',
        'formula',
        'meta',
        'unidade_medida',
        'frequencia',
        'referencia_gri',
        'ativo',
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
        return $this->belongsTo(User::class);
    }

}
