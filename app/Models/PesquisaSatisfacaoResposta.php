<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class PesquisaSatisfacaoResposta extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'pesquisas_satisfacao_respostas';

    protected $fillable = [
        'empresa_id',
        'pesquisa_id',
        'cliente_id',
        'respondente_id',
        'nota',
        'respostas_detalhadas',
        'classificacao',
        'respondido_em',
    ];

    protected $casts = [
        'nota' => 'decimal:2',
        'respostas_detalhadas' => 'array',
        'respondido_em' => 'datetime',  
    ];

    /**
     * Relacionamentos
     */


    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function pesquisa(): BelongsTo
    {
        return $this->belongsTo(PesquisaSatisfacao::class, 'pesquisa_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function respondente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'respondente_id');
    }

    protected static function booted(): void
    {
        //define automaticamente a classificação NPS antes de salvar  
        static::saving(function (PesquisaSatisfacaoResposta $resposta) {
            if ($resposta->nota !== null) {
                if ($resposta->nota >= 9) {
                    $resposta->classificacao = 'Promotor';
                } elseif ($resposta->nota >= 7) {
                    $resposta->classificacao = 'Neutro';
                } else {
                    $resposta->classificacao = 'Detrator';
                }
            }
        });

        //Recalcula total e nota média da pesquisa pai após salvar ou deletar
        static::saved(function (PesquisaSatisfacaoResposta $resposta) {
            $resposta->pesquisa->recalculaMetricas();
        });

        static::deleted(function (PesquisaSatisfacaoResposta $resposta) {
            $resposta->pesquisa->recalculaMetricas();
        });
    }
}
