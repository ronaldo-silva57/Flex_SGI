<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;
use App\Models\LicencaAmbiental;
use App\Models\AspectoAmbiental;
use App\Models\Processo;
use App\Models\User;
use App\Traits\Auditavel;

class NaoConformidadeAmbiental extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'nao_conformidades_ambientais';

    public const ORIGENS = ['Auditoria', 'Fiscalização', 'Monitoramento', 'Reclamação', 'Incidente', 'Outros'];

    public const GRAVIDADES = ['Baixa', 'Média', 'Alta', 'Crítica'];

    public const STATUS_ABERTA = 'Aberta';
    public const STATUS_EM_ANALISE = 'Em análise';
    public const STATUS_EM_ACAO = 'Em ação';
    public const STATUS_VERIFICACAO = 'Verificação';
    public const STATUS_FECHADA = 'Fechada';

    protected $fillable = [
        'empresa_id',
        'licenca_ambiental_id',
        'aspecto_ambiental_id',
        'processo_id',
        'responsavel_apuracao_id',
        'responsavel_tratamento_id',
        'codigo',
        'titulo',
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
        'acao_corretiva',
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

    public function licencaAmbiental(): BelongsTo
    {
        return $this->belongsTo(LicencaAmbiental::class);
    }

    public function aspectoAmbiental(): BelongsTo
    {
        return $this->belongsTo(AspectoAmbiental::class);
    }

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class);
    }

    public function responsavelApuracao(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_apuracao_id');
    }

    public function responsavelTratamento(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_tratamento_id');
    }

    /**
     * Scopes
     */

    public function scopeAbertas($query)
    {
        return $query->where('status', '!=', self::STATUS_FECHADA);
    }

    public function scopeAtrasadas($query)
    {
        return $query->where('prazo_tratamento', '<', now()->toDateString())
                     ->where('status', '!=', self::STATUS_FECHADA);
    }
}