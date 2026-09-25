<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Empresa;
use App\Models\User;
use App\Models\NaoConformidadeAmbiental;
use App\Traits\Auditavel;

class LicencaAmbiental extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'licencas_ambientais';

    public const STATUS_VIGENTE         = 'Vigente';
    public const STATUS_VENCIDA         = 'Vencida';
    public const STATUS_EM_RENOVACAO    = 'Em renovação';
    public const STATUS_SUSPENSA        = 'Suspensa';
    public const STATUS_CANCELADA       = 'Cancelada';

    public const TIPOS = ['LP', 'LI', 'LO', 'LAC', 'LAS', 'LAU', 'Outros'];

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'numero',
        'tipo',
        'orgao_emissor',
        'descricao',
        'condicionantes',
        'data_emissao',
        'data_validade',
        'data_renovacao',
        'arquivo_path',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_emissao'   => 'date',
        'data_validade'  => 'date',
        'data_renovacao' => 'date',
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

    public function naoConformidades(): HasMany
    {
        return $this->hasMany(NaoConformidadeAmbiental::class);
    }

    /**
     * Scopes
     */

    public function scopeVigentes($query)
    {
        return $query->where('status', self::STATUS_VIGENTE);
    }

    public function scopeVencidas($query)
    {
        return $query->where('data_validade', '<', now()->toDateString())
                     ->where('status', '!=', self::STATUS_CANCELADA);
    }

    public function scopeVencendoEm($query, int $dias = 30)
    {
        return $query->whereBetween('data_validade', [
            now()->toDateString(),
            now()->addDays($dias)->toDateString(),
        ]);
    }
}
