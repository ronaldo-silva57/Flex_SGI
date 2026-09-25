<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditavel;

class Epi extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'epis';

    protected $fillable = [
        'empresa_id',
        'nome',
        'descricao',
        'categoria',
        'ca',
        'validade_meses',
        'estoque_minimo',
        'estoque_atual',
        'ativo',
    ];

    protected $casts = [
        'validade_meses' => 'integer',
        'estoque_minimo' => 'integer',
        'estoque_atual' => 'integer',
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(EpiUsuario::class);
    }
}
