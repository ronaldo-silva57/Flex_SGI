<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\Auditavel;

class ComunicacaoInterna extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'comunicacoes_internas';

    protected $fillable = [
        'empresa_id',
        'autor_id',
        'titulo',
        'conteudo',
        'tipo',
        'exige_ciencia',
        'publicado_em',
        'expirado_em',
        'ativo',
    ];

    protected $casts = [
        'exige_ciencia' => 'boolean',
        'ativo'         => 'boolean',
        'publicado_em'  => 'datetime',
        'expirado_em'   => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function leituras()
    {
        return $this->belongsToMany(User::class, 'comunicacao_leituras', 'comunicacao_id', 'user_id')
                    ->withPivot('lido_em');
    }
}
