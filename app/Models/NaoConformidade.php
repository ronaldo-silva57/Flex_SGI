<?php

namespace App\Models;

use App\Traits\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NaoConformidade extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'nao_conformidades';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'norma_id',
        'clausula_id',
        'processo_id',
        'responsavel_apuracao_id',
        'responsavel_tratamento_id',
        'codigo',
        'titulo',
        'tipo',
        'origem',
        'local_ocorrencia',
        'descricao',
        'requisito_nao_atendido',
        'evidencia_inicial',
        'gravidade',
        'probabilidade',
        'prioridade',
        'recorrente',
        'status',
        'data_identificacao',
        'data_abertura',
        'prazo_tratamento',
        'data_analise',
        'data_verificacao',
        'data_encerramento',
        'justificativa_encerramento',
    ];

    protected $casts = [
        'recorrente' => 'boolean',
        'data_identificacao' => 'date',
        'data_abertura' => 'date',
        'prazo_tratamento' => 'date',
        'data_analise' => 'date',
        'data_verificacao' => 'date',
        'data_encerramento' => 'date',
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

    public function norma(): BelongsTo
    {
        return $this->belongsTo(Norma::class);
    }

    public function clausula(): BelongsTo
    {
        return $this->belongsTo(Clausula::class);
    }

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class);
    }

    public function responsavelApuracao(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'responsavel_apuracao_id'
        );
    }

    public function responsavelTratamento(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'responsavel_tratamento_id'
        );
    }

    public function acoesCorretivas(): HasMany
    {
        return $this->hasMany(AcaoCorretiva::class);
    }

    public function analisesCausa(): HasMany
    {
        return $this->hasMany(AnaliseCausa::class);
    }
}