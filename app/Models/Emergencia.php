<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;
use App\Models\User;
use App\Traits\Auditavel;

class Emergencia extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'emergencias';

    public const TIPOS = [
        'Incêndio', 'Vazamento Químico', 'Derramamento', 'Explosão',
        'Deslizamento', 'Enchente', 'Vazamento de Gás', 'Outros'
    ];

    public const GRAVIDADES = ['Baixa', 'Média', 'Alta', 'Crítica'];

    public const STATUS_ABERTO = 'Aberto';
    public const STATUS_EM_ATENDIMENTO = 'Em atendimento';
    public const STATUS_CONTROLADO = 'Controlado';
    public const STATUS_ENCERRADO = 'Encerrado';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'titulo',
        'tipo',
        'descricao',
        'localizacao',
        'data_ocorrencia',
        'data_encerramento',
        'gravidade',
        'causas',
        'impactos_ambientais',
        'acoes_imediatas',
        'acoes_corretivas',
        'plano_emergencia',
        'simulados_realizados',
        'data_ultimo_simulado',
        'status',
    ];

    protected $casts = [
        'data_ocorrencia' => 'datetime',
        'data_encerramento' => 'datetime',
        'data_ultimo_simulado' => 'date',
        'simulados_realizados' => 'integer',
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
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    /**
     * Scopes
     */

    public function scopeAbertos($query)
    {
        return $query->whereIn('status', [self::STATUS_ABERTO, self::STATUS_EM_ATENDIMENTO]);
    }

    public function scopeCriticos($query)
    {
        return $query->where('gravidade', 'Crítica');
    }
}