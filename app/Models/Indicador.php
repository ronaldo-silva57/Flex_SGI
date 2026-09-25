<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class Indicador extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'indicadores';

    protected $fillable = [
        'empresa_id',
        'processo_id',
        'norma_id',
        'responsavel_id',
        'codigo',
        'nome',
        'descricao',
        'formula',
        'meta',
        'unidade_medida',
        'frequencia',
        'tipo_meta',
        'ativo',
    ];

    protected $casts = [
        'meta'  => 'decimal:2',
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    } 

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class, 'processo_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function norma(): BelongsTo
    {
        return $this->belongsTo(Norma::class, 'norma_id');
    }
}
