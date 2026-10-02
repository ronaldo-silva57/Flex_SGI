<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditavel;

class PesquisaSatisfacao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'pesquisas_satisfacao';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'responsavel_id',
        'codigo',
        'titulo',
        'descricao',
        'tipo',
        'canal',
        'data_inicio',
        'data_fim',
        'status',
        'nota_media',
        'total_respostas',
    ];

    protected $casts = [
        'data_inicio'     => 'date',
        'data_fim'       => 'date',
        'nota_media'     => 'decimal:2',
        'total_respostas' => 'integer',
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

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function respostas(): HasMany
    {
        return $this->hasMany(
            PesquisaSatisfacaoResposta::class,
            'pesquisa_id'
        );
    }

    /**
     * Recalcula métricas a partir das respostas
     */
    public function recalculaMetricas(): void
    {
        $respostas = $this->respostas()->get();

        $total = $respostas->count();

        $media = $total > 0
            ? $respostas->avg('nota')
            : null;

        $this->update([
            'total_respostas' => $total,
            'nota_media'      => $media,
        ]);
    }
}