<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class Clausula extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'clausulas';

    protected $fillable = [
        'norma_id',
        'codigo',
        'titulo',
        'descricao',
        'clausula_pai_id',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer',
    ];

    /**
     * Relacionamento com a Norma
     */
    public function normas(): BelongsTo
    {
        return $this->belongsTo(Norma::class);
    }

    /**
     * Claúsula pai (para subcláusulas)
     */
    public function pai(): BelongsTo
    {
        return $this->belongsTo(Clausula::class, 'clausula_pai_id');
    }

    /**
     * Subcláusulas (Filhos)
     */
    public function filhos(): HasMany
    {
        return $this->hasMany(Clausula::class, 'clausula_pai_id')->orderBy('ordem');
    }

    public function norma(): BelongsTo
    {
        return $this->belongsTo(Norma::class);
    }
}
